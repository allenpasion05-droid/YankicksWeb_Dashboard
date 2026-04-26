<?php
session_start();
include 'api/db_connect.php';

// --- 1. KPI CALCULATIONS ---
// Total Revenue
$rev_result = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE status != 'cancelled'");
$total_revenue = $rev_result->fetch_assoc()['total'] ?? 0;

// Average Order Value
$aov_result = $conn->query("SELECT AVG(total_amount) as aov FROM orders WHERE status != 'cancelled'");
$avg_order_value = $aov_result->fetch_assoc()['aov'] ?? 0;

// Repeat Customer Rate
$repeat_result = $conn->query("SELECT COUNT(user_id) as total_customers, SUM(CASE WHEN order_count > 1 THEN 1 ELSE 0 END) as repeat_customers FROM (SELECT user_id, COUNT(*) as order_count FROM orders GROUP BY user_id) as user_orders");
$repeat_data = $repeat_result->fetch_assoc();
$repeat_rate = ($repeat_data['total_customers'] > 0) ? ($repeat_data['repeat_customers'] / $repeat_data['total_customers']) * 100 : 0;

// Completion Rate
$completed_count = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status='completed'")->fetch_assoc()['c'] ?? 0;
$total_count = $conn->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'] ?? 0;
$completion_rate = ($total_count > 0) ? ($completed_count / $total_count) * 100 : 0;

// --- 2. REVENUE OVER TIME (Chart 1) ---
$revenue_labels = [];
$revenue_totals = [];
// Groups orders by the start of the week (Monday)
$sql_revenue = "SELECT DATE_FORMAT(DATE_ADD(created_at, INTERVAL -WEEKDAY(created_at) DAY), '%b %e') as week_start, SUM(total_amount) as total FROM orders WHERE status != 'cancelled' GROUP BY YEARWEEK(created_at, 1) ORDER BY YEARWEEK(created_at, 1)";
$result_rev = $conn->query($sql_revenue);
while($row = $result_rev->fetch_assoc()) {
    $revenue_labels[] = 'Week of ' . $row['week_start'];
    $revenue_totals[] = $row['total'];
}


// --- 3. TOP SELLING PRODUCTS (Chart 2) ---
$product_names = [];
$product_sales = [];
$sql_products = "SELECT product_name, SUM(quantity) as total_sold FROM order_items GROUP BY product_name ORDER BY total_sold DESC LIMIT 5";
$result_prod = $conn->query($sql_products);
while($row = $result_prod->fetch_assoc()) {
    $product_names[] = $row['product_name'];
    $product_sales[] = $row['total_sold'];
}


// --- 4. LOW STOCK ALERTS (Predictive Stock-outs) ---
$low_stock_products = [];
// Grabbing products with less than 20 stock, ordering by lowest first
$sql_stock = "SELECT name, stock FROM products WHERE stock < 20 ORDER BY stock ASC LIMIT 3";
$result_stock = $conn->query($sql_stock);
while($row = $result_stock->fetch_assoc()) {
    $low_stock_products[] = $row;
}


// SECURITY: Admin Only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { 
    header("Location: login-register.php"); 
    exit(); 
}

// --- ACTION HANDLERS --- //
if (isset($_POST['delete_user'])) {
    $id = $_POST['user_id'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: admin_dashboard.php?view=users");
    exit();
}

if (isset($_POST['ban_user'])) {
    $id = $_POST['user_id'];
    $duration = $_POST['duration'];
    $ban_date = ($duration == 'forever') ? '2099-12-31 23:59:59' : date('Y-m-d H:i:s', strtotime($duration));
    $stmt = $conn->prepare("UPDATE users SET banned_until = ? WHERE id = ?");
    $stmt->bind_param("si", $ban_date, $id);
    $stmt->execute();
    header("Location: admin_dashboard.php?view=users");
    exit();
}

if (isset($_POST['unban_user'])) {
    $id = $_POST['user_id'];
    $conn->query("UPDATE users SET banned_until = NULL WHERE id=$id");
    header("Location: admin_dashboard.php?view=users");
    exit();
}

if (isset($_POST['delete_product'])) {
    $id = $_POST['product_id'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: admin_dashboard.php?view=products");
    exit();
}

if (isset($_POST['update_order_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE orders SET status='$status' WHERE id=$order_id");
    header("Location: admin_dashboard.php?view=orders");
    exit();
}

$view = isset($_GET['view']) ? $_GET['view'] : 'overview';

// --- ANALYTICS DATA --- //
$total_revenue = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE status='completed'")->fetch_assoc()['total'] ?? 0;
$total_orders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'] ?? 0;
$total_users = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='user'")->fetch_assoc()['total'] ?? 0;
$total_products = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'] ?? 0;

// Sales by Month (Last 6 months)
$sales_data = [];
for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i months"));
    $month_name = date('M', strtotime("-$i months"));
    $res = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE status='completed' AND created_at LIKE '$month%'");
    $sales_data[$month_name] = $res->fetch_assoc()['total'] ?? 0;
}

// Order Status Distribution (For Chart 4)
$status_names = [];
$status_counts = [];
$res_status = $conn->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status");
while($row = $res_status->fetch_assoc()) {
    $status_names[] = ucfirst($row['status']); // Capitalizes the first letter
    $status_counts[] = $row['count'];
}

// Payment Methods (For Chart 3)
$payment_names = [];
$payment_counts = [];
$res_pay = $conn->query("SELECT payment_method, COUNT(*) as count FROM orders GROUP BY payment_method");
while($row = $res_pay->fetch_assoc()) {
    $payment_names[] = $row['payment_method'];
    $payment_counts[] = $row['count'];
}

// Variables for Prescriptive Cards
$top_product = !empty($product_names) ? $product_names[0] : 'Top Products';
$top_category = !empty($category_names) ? $category_names[0] : 'Popular Category';
$urgent_restock = !empty($low_stock_products) ? $low_stock_products[0]['name'] : 'Inventory';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - YanKicks</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 bg-white border-r border-gray-200 flex flex-col fixed h-full">
            <div class="p-8">
                <div class="flex items-center gap-3 mb-12">
                    <img src="assets/images/yankicks_logo.jpg" alt="Logo" class="h-10 w-10 object-contain">
                    <span class="text-xl font-black uppercase tracking-tighter">YanKicks</span>
                </div>
                
                <nav class="space-y-2">
                    <a href="?view=overview" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?php echo $view == 'overview' ? 'bg-black text-white shadow-lg' : 'text-gray-500 hover:bg-gray-100'; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                        Overview
                    </a>
                    <a href="?view=users" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?php echo $view == 'users' ? 'bg-black text-white shadow-lg' : 'text-gray-500 hover:bg-gray-100'; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        Manage Users
                    </a>
                    <a href="?view=products" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?php echo $view == 'products' ? 'bg-black text-white shadow-lg' : 'text-gray-500 hover:bg-gray-100'; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        Manage Products
                    </a>
                    <a href="?view=orders" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?php echo $view == 'orders' ? 'bg-black text-white shadow-lg' : 'text-gray-500 hover:bg-gray-100'; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        Manage Orders
                    </a>
                    <a href="?view=analytics" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all <?php echo $view == 'analytics' ? 'bg-black text-white shadow-lg' : 'text-gray-500 hover:bg-gray-100'; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3v18m4-14v14m4-10v10M7 13v8M3 17v4" /></svg>
                        Analytics
                    </a>

                </nav>
            </div>
            
            <div class="mt-auto p-8">
                <a href="logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Sign Out
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-72 p-12">
            
            <?php if ($view == 'overview'): ?>
                <div class="mb-12">
                    <h1 class="text-4xl font-black uppercase tracking-tighter">Dashboard Overview</h1>
                    <p class="text-gray-500 mt-2">Welcome back, Admin. Here's what's happening today.</p>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-2">Total Revenue</p>
                        <h3 class="text-3xl font-black">₱<?php echo number_format($total_revenue, 2); ?></h3>
                    </div>
                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-2">Total Orders</p>
                        <h3 class="text-3xl font-black"><?php echo $total_orders; ?></h3>
                    </div>
                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-2">Total Users</p>
                        <h3 class="text-3xl font-black"><?php echo $total_users; ?></h3>
                    </div>
                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-2">Total Products</p>
                        <h3 class="text-3xl font-black"><?php echo $total_products; ?></h3>
                    </div>
                </div>

               <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="text-lg font-bold">Recent Orders</h4>
                            <a href="?view=orders" class="text-sm font-bold text-blue-600 hover:underline">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="text-gray-500 border-b border-gray-100">
                                    <tr>
                                        <th class="pb-3 font-bold">Order ID</th>
                                        <th class="pb-3 font-bold">Amount</th>
                                        <th class="pb-3 font-bold">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <?php
                                    $recent_orders = $conn->query("SELECT id, total_amount, status FROM orders ORDER BY created_at DESC LIMIT 5");
                                    while($ro = $recent_orders->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td class="py-3 font-bold">#<?php echo $ro['id']; ?></td>
                                        <td class="py-3">₱<?php echo number_format($ro['total_amount'], 2); ?></td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 bg-gray-100 rounded text-xs font-bold uppercase"><?php echo $ro['status']; ?></span>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col">
                        <h4 class="text-lg font-bold mb-6">Action Required</h4>
                        <div class="flex-1 space-y-4">
                            <?php 
                            $pending_count = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status='pending'")->fetch_assoc()['c'];
                            if($pending_count > 0): 
                            ?>
                            <div class="p-4 bg-yellow-50 text-yellow-800 rounded-xl border border-yellow-100">
                                <p class="font-bold text-sm">🚚 <?php echo $pending_count; ?> Orders to Ship</p>
                                <p class="text-xs mt-1">You have orders waiting to be processed.</p>
                            </div>
                            <?php endif; ?>

                            <?php if(count($low_stock_products) > 0): ?>
                            <div class="p-4 bg-red-50 text-red-800 rounded-xl border border-red-100">
                                <p class="font-bold text-sm">⚠️ Low Inventory</p>
                                <p class="text-xs mt-1"><?php echo count($low_stock_products); ?> products are running out of stock.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php elseif ($view == 'users'): ?>
                <div class="flex justify-between items-end mb-12">
                    <div>
                        <h1 class="text-4xl font-black uppercase tracking-tighter">Manage Users</h1>
                        <p class="text-gray-500 mt-2">View and manage your customer base.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">User</th>
                                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Role</th>
                                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php
                            $res = $conn->query("SELECT * FROM users ORDER BY id DESC");
                            while($row = $res->fetch_assoc()): 
                                $is_banned = ($row['banned_until'] && new DateTime($row['banned_until']) > new DateTime());
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-600">
                                            <?php echo strtoupper(substr($row['full_name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <p class="font-bold"><?php echo $row['full_name']; ?></p>
                                            <p class="text-sm text-gray-500"><?php echo $row['email']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider <?php echo $row['role'] == 'admin' ? 'bg-black text-white' : 'bg-gray-100 text-gray-600'; ?>">
                                        <?php echo $row['role']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <?php if($is_banned): ?>
                                        <span class="text-red-500 text-sm font-bold flex items-center gap-1">
                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span> Banned
                                        </span>
                                    <?php else: ?>
                                        <span class="text-green-500 text-sm font-bold flex items-center gap-1">
                                            <span class="w-2 h-2 bg-green-500 rounded-full"></span> Active
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <?php if($row['role'] !== 'admin'): ?>
                                        <div class="flex justify-end gap-3">
                                            <?php if($is_banned): ?>
                                                <form method="POST" class="inline">
                                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" name="unban_user" class="text-sm font-bold text-black hover:underline">Unban</button>
                                                </form>
                                            <?php else: ?>
                                                <form method="POST" class="inline flex gap-2">
                                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                                    <select name="duration" class="text-xs border rounded-lg px-2 py-1">
                                                        <option value="+1 month">1 Mo</option>
                                                        <option value="forever">Perm</option>
                                                    </select>
                                                    <button type="submit" name="ban_user" class="text-sm font-bold text-red-500 hover:underline">Ban</button>
                                                </form>
                                            <?php endif; ?>
                                            <form method="POST" onsubmit="return confirm('Delete user?');" class="inline">
                                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="delete_user" class="text-gray-400 hover:text-red-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($view == 'products'): ?>
                <div class="flex justify-between items-end mb-12">
                    <div>
                        <h1 class="text-4xl font-black uppercase tracking-tighter">Manage Products</h1>
                        <p class="text-gray-500 mt-2">Control your inventory and product listings.</p>
                    </div>
                    <a href="admin_add_product.php" class="bg-black text-white px-8 py-4 rounded-2xl font-bold hover:bg-gray-900 transition-all shadow-lg shadow-black/10">+ Add Product</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    <?php
                    $res = $conn->query("SELECT * FROM products ORDER BY id DESC");
                    while($row = $res->fetch_assoc()): ?>
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm group">
                        <div class="aspect-square rounded-2xl bg-gray-50 mb-6 overflow-hidden relative">
                            <img src="assets/images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold">
                                <?php echo $row['category']; ?>
                            </div>
                        </div>
                        <h4 class="text-lg font-bold mb-1"><?php echo $row['name']; ?></h4>
                        <p class="text-2xl font-black mb-6">₱<?php echo number_format($row['price'], 2); ?></p>
                        <div class="flex gap-3">
                            <a href="admin_edit_product.php?id=<?php echo $row['id']; ?>" class="flex-1 bg-gray-100 text-center py-3 rounded-xl font-bold hover:bg-gray-200 transition-all">Edit</a>
                            <form method="POST" onsubmit="return confirm('Delete product?');" class="flex-1">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_product" class="w-full bg-red-50 text-red-500 py-3 rounded-xl font-bold hover:bg-red-100 transition-all">Delete</button>
                            </form>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>

            <?php elseif ($view == 'orders'): ?>
                <div class="mb-12">
                    <h1 class="text-4xl font-black uppercase tracking-tighter">Manage Orders</h1>
                    <p class="text-gray-500 mt-2">Track and update customer orders.</p>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Order ID</th>
                                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Customer</th>
                                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Total</th>
                                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php
                            $sql = "SELECT orders.*, users.full_name FROM orders JOIN users ON orders.user_id = users.id ORDER BY created_at DESC";
                            $res = $conn->query($sql);
                            while($row = $res->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-8 py-6 font-bold">#<?php echo $row['id']; ?></td>
                                <td class="px-8 py-6"><?php echo $row['full_name']; ?></td>
                                <td class="px-8 py-6 font-bold">₱<?php echo number_format($row['total_amount'], 2); ?></td>
                                <td class="px-8 py-6">
                                    <?php
                                    $status_colors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'shipped' => 'bg-blue-100 text-blue-700',
                                        'completed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700'
                                    ];
                                    $color = $status_colors[strtolower($row['status'])] ?? 'bg-gray-100 text-gray-700';
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider <?php echo $color; ?>">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <form method="POST" class="flex justify-end gap-2">
                                        <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                        <select name="status" class="text-xs border rounded-lg px-2 py-1 outline-none focus:border-black">
                                            <option value="pending" <?php if($row['status']=='pending') echo 'selected';?>>Pending</option>
                                            <option value="shipped" <?php if($row['status']=='shipped') echo 'selected';?>>Shipped</option>
                                            <option value="completed" <?php if($row['status']=='completed') echo 'selected';?>>Completed</option>
                                            <option value="cancelled" <?php if($row['status']=='cancelled') echo 'selected';?>>Cancelled</option>
                                        </select>
                                        <button type="submit" name="update_order_status" class="bg-black text-white px-4 py-1 rounded-lg text-xs font-bold hover:bg-gray-800 transition-all">Update</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

           <?php elseif ($view == 'analytics'): ?>
    <div class="mb-8">
        <h1 class="text-4xl font-black uppercase tracking-tighter">Analytics Dashboard</h1>
        <p class="text-gray-500 mt-2">Comprehensive store performance and insights.</p>
    </div>

    <div class="mb-10">
        <h2 class="text-xl font-black mb-1 flex items-center gap-2">
            <span class="bg-black text-white px-2.5 py-0.5 rounded text-sm">1</span> DESCRIPTIVE
        </h2>
        <p class="text-gray-500 text-sm mb-6">What happened? Historical performance metrics.</p>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mb-2">Total Revenue</p>
                <h3 class="text-3xl font-black">₱<?php echo number_format($total_revenue, 2); ?></h3>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mb-2">Completion Rate</p>
                <h3 class="text-3xl font-black"><?php echo number_format($completion_rate, 1); ?>%</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mb-2">Avg Order Value</p>
                <h3 class="text-3xl font-black">₱<?php echo number_format($avg_order_value, 2); ?></h3>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mb-2">Repeat Customer</p>
                <h3 class="text-3xl font-black"><?php echo number_format($repeat_rate, 1); ?>%</h3>
            </div>
        </div>

       <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm min-w-0 flex flex-col">
                <h4 class="text-sm font-bold uppercase tracking-wider mb-4">Revenue Over Time</h4>
                <div class="relative w-full flex-1 min-h-[250px] md:min-h-[300px]">
                    <canvas id="revenueOverTimeChart"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm min-w-0 flex flex-col">
                <h4 class="text-sm font-bold uppercase tracking-wider mb-4">Top Selling Products</h4>
                <div class="relative w-full flex-1 min-h-[250px] md:min-h-[300px]">
                    <canvas id="topSellingChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-10">
        <h2 class="text-xl font-black mb-1 flex items-center gap-2">
            <span class="bg-black text-white px-2.5 py-0.5 rounded text-sm">2</span> DIAGNOSTIC
        </h2>
        <p class="text-gray-500 text-sm mb-6">Why did it happen? Drill-down into behaviors.</p>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm min-w-0 flex flex-col">
                <h4 class="text-sm font-bold uppercase tracking-wider mb-4">Orders by Payment Method</h4>
                <div class="relative w-full flex-1 min-h-[250px] md:min-h-[300px]">
                    <canvas id="funnelChart"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm min-w-0 flex flex-col">
                <h4 class="text-sm font-bold uppercase tracking-wider mb-4">Order Status Distribution</h4>
                <div class="relative w-full flex-1 min-h-[250px] md:min-h-[300px]">
                    <canvas id="refundChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-10">
        <h2 class="text-xl font-black mb-1 flex items-center gap-2">
            <span class="bg-black text-white px-2.5 py-0.5 rounded text-sm">3</span> PREDICTIVE
        </h2>
        <p class="text-gray-500 text-sm mb-6">What will happen? Forecasts and trends.</p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm min-w-0 flex flex-col">
                <h4 class="text-sm font-bold uppercase tracking-wider mb-4">3-Week Revenue Forecast</h4>
                <div class="relative w-full flex-1 min-h-[250px] md:min-h-[300px]">
                    <canvas id="forecastChart"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col">
                <h4 class="text-sm font-bold uppercase tracking-wider mb-6">Expected Stock-Outs (Low Stock)</h4>
                <div class="flex-1 space-y-6 mt-4">
                    <?php foreach($low_stock_products as $item): ?>
                    <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                        <span class="font-bold text-sm"><?php echo $item['name']; ?></span>
                        <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded">
                            ONLY <?php echo $item['stock']; ?> LEFT
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

   <div class="mb-10">
        <h2 class="text-xl font-black mb-1 flex items-center gap-2">
            <span class="bg-black text-white px-2.5 py-0.5 rounded text-sm">4</span> PRESCRIPTIVE
        </h2>
        <p class="text-gray-500 text-sm mb-6">What should we do? Actionable recommendations based on real data.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold bg-black text-white px-2 py-1 rounded uppercase tracking-wider w-max inline-block">High Priority</span>
                    <p class="font-bold text-sm mt-4 mb-2">Restock <?php echo $urgent_restock; ?> immediately</p>
                </div>
                <p class="text-red-500 font-bold text-sm mt-4">Critical Inventory Level</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold bg-gray-100 text-gray-600 px-2 py-1 rounded uppercase tracking-wider w-max inline-block">Medium Priority</span>
                    <p class="font-bold text-sm mt-4 mb-2">Launch promo for <?php echo $top_category; ?> shoes</p>
                </div>
                <p class="text-green-500 font-bold text-sm mt-4">Highest Converting Category</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold bg-gray-100 text-gray-600 px-2 py-1 rounded uppercase tracking-wider w-max inline-block">Medium Priority</span>
                    <p class="font-bold text-sm mt-4 mb-2">Target lapsed customers with 15% discount</p>
                </div>
                <p class="text-green-500 font-bold text-sm mt-4">Boost Repeat Customer Rate</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold bg-black text-white px-2 py-1 rounded uppercase tracking-wider w-max inline-block">High Priority</span>
                    <p class="font-bold text-sm mt-4 mb-2">Increase ad spend on <?php echo $top_product; ?></p>
                </div>
                <p class="text-green-500 font-bold text-sm mt-4">Current Top Seller</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Inter', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif";
        Chart.defaults.color = '#9CA3AF';
        const gridConfig = { color: '#F3F4F6', drawBorder: false };

        // 1. Revenue Over Time
        new Chart(document.getElementById('revenueOverTimeChart'), {
            type: 'line',
            data: {
                // Change variable to match new weekly PHP array
                labels: <?php echo json_encode($revenue_labels); ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?php echo json_encode($revenue_totals); ?>,
                    borderColor: '#000',
                    backgroundColor: 'rgba(0, 0, 0, 0.05)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { 
                        grid: gridConfig,
                        min: 0,
                        ticks: { callback: value => '₱' + (value/1000) + 'k' } 
                    }
                }
            }
        });

        // 2. Top Selling Products
        new Chart(document.getElementById('topSellingChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($product_names); ?>,
                datasets: [{
                    data: <?php echo json_encode($product_sales); ?>,
                    backgroundColor: '#000',
                    borderRadius: 4,
                    barThickness: 'flex', // Automatically adjusts thickness based on screen size
                    maxBarThickness: 24
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: gridConfig },
                    y: { 
                        grid: { display: false },
                        ticks: { autoSkip: false } // Prevents labels from disappearing on small screens
                    }
                }
            }
        });

       // 3. Orders by Payment Method
        new Chart(document.getElementById('funnelChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($payment_names); ?>,
                datasets: [{
                    data: <?php echo json_encode($payment_counts); ?>,
                    backgroundColor: ['#111827', '#374151', '#6B7280', '#9CA3AF'],
                    borderRadius: 4,
                    barThickness: 'flex',
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { 
                        grid: gridConfig,
                        ticks: { stepSize: 1 } // Ensures payment counts show as whole numbers
                    }
                }
            }
        });

       // 4. Order Status Distribution
        const statusLabels = <?php echo json_encode($status_names); ?>;
        const statusData = <?php echo json_encode($status_counts); ?>;
        
        // Updated Color Scheme: Minimalist Grays and Blacks to match the dashboard
        const colorMapping = {
            'Completed': '#111827', // Almost Black (gray-900)
            'Shipped': '#4B5563',   // Dark Gray (gray-600)
            'Pending': '#9CA3AF',   // Medium Gray (gray-400)
            'Cancelled': '#E5E7EB'  // Light Gray (gray-200)
        };
        const bgColors = statusLabels.map(label => colorMapping[label] || '#9CA3AF');

        new Chart(document.getElementById('refundChart'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: bgColors,
                    borderWidth: 0 // Removes the white borders for a cleaner look
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { 
                        display: true,
                        position: 'right',
                        labels: { usePointStyle: true, boxWidth: 10 }
                    } 
                }
            }
        });
       // 5. 3-Week Revenue Forecast (Dynamic Trend)
        const rawLabels = <?php echo json_encode($revenue_labels); ?>;
        const actualTotals = <?php echo json_encode($revenue_totals); ?>.map(Number);

        // Step 1: Calculate the historical average weekly growth trajectory
        let lastValue = actualTotals.length > 0 ? actualTotals[actualTotals.length - 1] : 0;
        let avgGrowth = 0;
        
        if (actualTotals.length > 1) {
            let totalDiff = 0;
            for (let i = 1; i < actualTotals.length; i++) {
                totalDiff += (actualTotals[i] - actualTotals[i-1]);
            }
            avgGrowth = totalDiff / (actualTotals.length - 1);
        }

        // Step 2: Prepare the timeline arrays
        const allLabels = [...rawLabels];
        let forecastData = Array(Math.max(0, actualTotals.length - 1)).fill(null);
        forecastData.push(lastValue); 

        // Step 3: Generate the next 3 weeks of predictions
        let currentForecastVal = lastValue;
        for (let i = 1; i <= 3; i++) {
            allLabels.push("Week +" + i + " (Est)");
            
            // Add the average growth to the next week
            currentForecastVal = Math.max(0, currentForecastVal + avgGrowth); 
            forecastData.push(currentForecastVal);
        }

        // Step 4: Draw the Dual-Line Chart
        new Chart(document.getElementById('forecastChart'), {
            type: 'line',
            data: {
                labels: allLabels,
                datasets: [
                    {
                        label: 'Actual Revenue',
                        data: actualTotals,
                        borderColor: '#000',
                        backgroundColor: 'rgba(0, 0, 0, 0.05)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: '#000'
                    },
                    {
                        label: 'Forecasted Trend',
                        data: forecastData,
                        borderColor: '#9CA3AF',
                        borderDash: [6, 6],
                        fill: false,
                        tension: 0.4,
                        borderWidth: 2,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#9CA3AF',
                        pointRadius: 4,
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: true, position: 'top', labels: { boxWidth: 12, usePointStyle: true } } 
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { 
                        grid: gridConfig,
                        min: 0,
                        ticks: { callback: value => '₱' + (value/1000) + 'k' } 
                    }
                }
            }
        });
    </script>

            <?php endif; ?>
        </main>
    </div>
</body>
</html>
