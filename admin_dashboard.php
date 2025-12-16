<?php
session_start();
include 'api/db_connect.php';

// SECURITY: Admin Only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { 
    header("Location: login-register.php"); 
    exit(); 
}

// --- ACTION HANDLERS --- //

// 1. DELETE USER
if (isset($_POST['delete_user'])) {
    $id = $_POST['user_id'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: admin_dashboard.php?view=users");
    exit();
}

// 2. BAN USER
if (isset($_POST['ban_user'])) {
    $id = $_POST['user_id'];
    $duration = $_POST['duration'];
    
    if ($duration == 'forever') {
        $ban_date = '2099-12-31 23:59:59';
    } else {
        $ban_date = date('Y-m-d H:i:s', strtotime($duration));
    }
    
    $stmt = $conn->prepare("UPDATE users SET banned_until = ? WHERE id = ?");
    $stmt->bind_param("si", $ban_date, $id);
    $stmt->execute();
    header("Location: admin_dashboard.php?view=users");
    exit();
}

// 3. UNBAN USER
if (isset($_POST['unban_user'])) {
    $id = $_POST['user_id'];
    $conn->query("UPDATE users SET banned_until = NULL WHERE id=$id");
    header("Location: admin_dashboard.php?view=users");
    exit();
}

// 4. DELETE PRODUCT
if (isset($_POST['delete_product'])) {
    $id = $_POST['product_id'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: admin_dashboard.php?view=products");
    exit();
}

// 5. UPDATE ORDER STATUS
if (isset($_POST['update_order_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE orders SET status='$status' WHERE id=$order_id");
    header("Location: admin_dashboard.php?view=orders");
    exit();
}

$view = isset($_GET['view']) ? $_GET['view'] : 'users';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - YanKicks</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* ADMIN SPECIFIC OVERRIDES */
        .admin-body { display: flex; min-height: 100vh; background-color: #f9f9f9; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
        
        /* Sidebar */
        .sidebar { 
            width: 260px; 
            background: #ffffff; 
            border-right: 1px solid #e0e0e0; 
            display: flex; 
            flex-direction: column; 
            padding: 30px 20px; 
            position: fixed; 
            height: 100vh;
        }
        .admin-logo { 
            font-size: 22px; 
            font-weight: 800; 
            color: #000; 
            text-transform: uppercase; 
            margin-bottom: 50px; 
            letter-spacing: 1px; 
            display: flex; 
            align-items: center; 
            gap: 10px;
        }
        .sidebar a { 
            color: #666; 
            text-decoration: none; 
            padding: 12px 15px; 
            display: flex; 
            align-items: center; 
            gap: 10px;
            margin-bottom: 8px; 
            border-radius: 6px; 
            font-size: 14px; 
            font-weight: 500;
            transition: all 0.2s ease; 
        }
        .sidebar a:hover { background: #f5f5f5; color: #000; }
        .sidebar a.active { background: #000; color: #fff; }
        
        /* Main Content */
        .content { 
            flex: 1; 
            margin-left: 260px; 
            padding: 40px; 
        }
        
        h1 { font-size: 28px; font-weight: 700; margin-bottom: 30px; color: #000; }

        /* Tables */
        .table-container { background: #fff; border-radius: 8px; border: 1px solid #e0e0e0; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #f8f8f8; color: #333; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; padding: 16px; border-bottom: 1px solid #eee; text-align: left; }
        td { padding: 16px; border-bottom: 1px solid #eee; color: #444; font-size: 14px; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        
        /* Buttons */
        .btn { padding: 8px 14px; border: none; cursor: pointer; border-radius: 4px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-block; transition: background 0.2s; }
        .btn-black { background: #000; color: #fff; }
        .btn-black:hover { background: #333; }
        .btn-outline { background: transparent; border: 1px solid #ddd; color: #333; }
        .btn-outline:hover { border-color: #000; color: #000; }
        .btn-danger { background: #fff; border: 1px solid #ff4d4d; color: #ff4d4d; }
        .btn-danger:hover { background: #ff4d4d; color: white; }
        
        /* Forms */
        select { padding: 6px 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; background: white; outline: none; }
        select:focus { border-color: #000; }

        /* Badges */
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .badge-admin { background: #000; color: #fff; }
        .badge-user { background: #eee; color: #555; }
        .badge-banned { background: #ff4d4d; color: white; }
        
        /* Order Status Colors */
        .status-pending { color: #f39c12; background: #fff8e1; }
        .status-shipped { color: #3498db; background: #e3f2fd; }
        .status-completed { color: #27ae60; background: #e8f5e9; }
        .status-cancelled { color: #e74c3c; background: #fce4ec; }

        /* Add Product Button */
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    </style>
</head>
<body class="admin-body">

    <div class="sidebar">
        <div class="admin-logo">
            <img src="assets/images/yankicks_logo.jpg" alt="Logo" style="height: 28px;">
            YanKicks
        </div>
        <a href="?view=users" class="<?php echo $view == 'users' ? 'active' : ''; ?>">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            Manage Users
        </a>
        <a href="?view=products" class="<?php echo $view == 'products' ? 'active' : ''; ?>">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            Manage Products
        </a>
        <a href="?view=orders" class="<?php echo $view == 'orders' ? 'active' : ''; ?>">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
            Manage Orders
        </a>
        <a href="logout.php" style="margin-top:auto; color:#ff4d4d;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            Sign Out
        </a>
    </div>

    <div class="content">
        
        <?php if ($view == 'users'): ?>
            <div class="header-actions">
                <h1>Manage Users</h1>
            </div>
            <div class="table-container">
                <table>
                    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status / Actions</th></tr></thead>
                    <tbody>
                        <?php
                        $res = $conn->query("SELECT * FROM users ORDER BY id DESC");
                        while($row = $res->fetch_assoc()): 
                            $is_banned = ($row['banned_until'] && new DateTime($row['banned_until']) > new DateTime());
                        ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td><strong><?php echo $row['full_name']; ?></strong></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><span class="badge <?php echo $row['role'] == 'admin' ? 'badge-admin' : 'badge-user'; ?>"><?php echo strtoupper($row['role']); ?></span></td>
                            <td>
                                <?php if($row['role'] == 'admin'): ?>
                                    <span style="color:#999; font-size:12px;">Protected</span>
                                <?php else: ?>
                                    <div style="display:flex; gap:8px; align-items:center;">
                                        
                                        <?php if($is_banned): ?>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="unban_user" class="btn btn-outline">Unban</button>
                                            </form>
                                            <span class="badge badge-banned">Banned</span>
                                        <?php else: ?>
                                            <form method="POST" style="display:inline; display:flex; gap:5px;">
                                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                                <select name="duration">
                                                    <option value="+1 month">1 Mo</option>
                                                    <option value="+1 year">1 Yr</option>
                                                    <option value="forever">Perm</option>
                                                </select>
                                                <button type="submit" name="ban_user" class="btn btn-black">Ban</button>
                                            </form>
                                        <?php endif; ?>

                                        <form method="POST" onsubmit="return confirm('Permanently delete this user?');" style="display:inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_user" class="btn btn-danger">×</button>
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
            <div class="header-actions">
                <h1>Manage Products</h1>
                <a href="admin_add_product.php" class="btn btn-black">+ Add New Product</a>
            </div>
            <div class="table-container">
                <table>
                    <thead><tr><th>Image</th><th>Name</th><th>Price</th><th>Category</th><th>Actions</th></tr></thead>
                    <tbody>
                        <?php
                        $res = $conn->query("SELECT * FROM products ORDER BY id DESC");
                        while($row = $res->fetch_assoc()): ?>
                        <tr>
                            <td><img src="<?php echo $row['image']; ?>" width="50" style="border-radius:4px; border:1px solid #eee;"></td>
                            <td><strong><?php echo $row['name']; ?></strong></td>
                            <td>₱<?php echo number_format($row['price'], 2); ?></td>
                            <td><span class="badge badge-user"><?php echo $row['category']; ?></span></td>
                            <td>
                                <div style="display:flex; gap:5px;">
                                    <a href="admin_edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-outline">Edit</a>
                                    <form method="POST" onsubmit="return confirm('Delete this product?');">
                                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($view == 'orders'): ?>
            <div class="header-actions">
                <h1>Manage Orders</h1>
            </div>
            <div class="table-container">
                <table>
                    <thead><tr><th>Order ID</th><th>Customer</th><th>Total</th><th>Current Status</th><th>Update Status</th></tr></thead>
                    <tbody>
                        <?php
                        $sql = "SELECT orders.*, users.full_name FROM orders JOIN users ON orders.user_id = users.id ORDER BY created_at DESC";
                        $res = $conn->query($sql);
                        while($row = $res->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td><strong><?php echo $row['full_name']; ?></strong></td>
                            <td>₱<?php echo number_format($row['total_amount'], 2); ?></td>
                            <td>
                               <span class="badge status-<?php echo strtolower($row['status']); ?>">
                                   <?php echo ucfirst($row['status']); ?>
                               </span>
                            </td>
                            <td>
                                <form method="POST" style="display:flex; gap:5px;">
                                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                    <select name="status">
                                        <option value="pending" <?php if($row['status']=='pending') echo 'selected';?>>Pending</option>
                                        <option value="shipped" <?php if($row['status']=='shipped') echo 'selected';?>>Shipped</option>
                                        <option value="completed" <?php if($row['status']=='completed') echo 'selected';?>>Completed</option>
                                        <option value="cancelled" <?php if($row['status']=='cancelled') echo 'selected';?>>Cancelled</option>
                                    </select>
                                    <button type="submit" name="update_order_status" class="btn btn-black">Update</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
    </div>
</body>
</html>