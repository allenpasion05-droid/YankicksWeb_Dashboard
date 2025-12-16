<?php
session_start();
include 'api/db_connect.php';

// 1. Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login-register.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// 2. Fetch User Details
$sql_user = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - YanKicks</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* CSS for the Orders Table (Matches your clean design) */
        .orders-section { margin-top: 50px; }
        .order-card { background: #fff; border: 1px solid #eee; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .order-header { display: flex; justify-content: space-between; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px; margin-bottom: 15px; }
        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; color: white; text-transform: uppercase; }
        
        .status-pending { background: #f39c12; }
        .status-shipped { background: #3498db; }
        .status-completed { background: #2ecc71; }
        .status-cancelled { background: #e74c3c; }

        .order-items-list div { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; color: #555; }
        .order-total { text-align: right; font-weight: bold; font-size: 18px; margin-top: 15px; color: #333; }
        
        /* Logout Button Style Override */
        .logout-card { background-color: #ffebee !important; border-color: #ffcdd2 !important; }
        .logout-card:hover { background-color: #ffcdd2 !important; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <img src="assets/images/yankicks_logo.jpg" alt="YanKicks Logo">
                <span>YanKicks</span>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="customer-service.php">Customer Service</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="legal.php">Legal</a></li>
            </ul>
            <div class="nav-cart">
                <a href="account.php" class="account-btn" title="My Account">
                    <svg class="account-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
                <button class="cart-btn" id="cartBtn" title="Shopping Cart">
                    <svg class="cart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-count" id="cartCount">0</span>
                </button>
            </div>
        </div>
    </nav>

    <aside class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h2>Your Cart</h2>
            <button class="close-cart" id="closeCart">&times;</button>
        </div>
        <div class="cart-items" id="cartItems"></div>
        <div class="cart-footer">
            <div class="cart-total">
                <strong>Total:</strong>
                <span id="cartTotal">₱0.00</span>
            </div>
            <button class="checkout-btn">Proceed to Checkout</button>
        </div>
    </aside>

    <main class="account-page">
        <div class="container">
            <div class="page-header">
                <h1>Welcome, <?php echo $user_name; ?>!</h1>
                <p>Manage your account, view orders, and update preferences.</p>
            </div>

            <div class="account-links">
                <a href="logout.php" class="account-link-card logout-card">
                    <h3>Logout</h3>
                    <p>Sign out of your account securely</p>
                </a>
                
                <a href="#my-orders-section" class="account-link-card">
                    <h3>My Orders</h3>
                    <p>View your order history and track shipments</p>
                </a>
                
                <a href="#" class="account-link-card">
                    <h3>Wishlist</h3>
                    <p>Save your favorite items for later</p>
                </a>
                
                <a href="#" class="account-link-card">
                    <h3>Account Settings</h3>
                    <p>Update your profile and preferences</p>
                </a>
            </div>

            <div class="orders-section" id="my-orders-section">
                <h2>Your Recent Orders</h2>
                <hr style="margin-bottom: 20px; border: 0; border-top: 1px solid #ddd;">

                <?php
                // Fetch Orders for THIS user
                $sql_orders = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
                $stmt_orders = $conn->prepare($sql_orders);
                $stmt_orders->bind_param("i", $user_id);
                $stmt_orders->execute();
                $result_orders = $stmt_orders->get_result();

                if ($result_orders->num_rows > 0) {
                    while($order = $result_orders->fetch_assoc()) {
                        $order_id = $order['id'];
                        // Fetch items for this order
                        $sql_items = "SELECT * FROM order_items WHERE order_id = ?";
                        $stmt_items = $conn->prepare($sql_items);
                        $stmt_items->bind_param("i", $order_id);
                        $stmt_items->execute();
                        $result_items = $stmt_items->get_result();
                ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <strong style="font-size: 18px;">Order #<?php echo $order_id; ?></strong>
                                <div style="color: #888; font-size: 14px; margin-top: 4px;">
                                    Placed on <?php echo date('M d, Y', strtotime($order['created_at'])); ?>
                                </div>
                            </div>
                            <div>
                                <span class="status-badge status-<?php echo $order['status']; ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </div>
                        </div>

                        <div class="order-items-list">
                            <?php while($item = $result_items->fetch_assoc()): ?>
                                <div>
                                    <span><?php echo $item['quantity']; ?>x <?php echo $item['product_name']; ?></span>
                                    <span>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <div class="order-total">
                            Total: ₱<?php echo number_format($order['total_amount'], 2); ?>
                        </div>
                    </div>
                <?php 
                    } // End While Loop
                } else {
                    echo "<p style='text-align:center; padding: 20px; background:#f9f9f9;'>You haven't placed any orders yet. <a href='shop.php'>Go Shopping!</a></p>";
                }
                ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>About Us</h4>
                    <ul>
                        <li><a href="our-story.php">Our Story</a></li>
                        <li><a href="mission-vision.php">Mission/Vision</a></li>
                        <li><a href="why-choose-us.php">Why Choose Us</a></li>
                        <li><a href="store-locations.php">Store Locations</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="shipping-delivery.php">Shipping & Delivery Info</a></li>
                        <li><a href="returns-exchange.php">Returns & Exchange Policy</a></li>
                        <li><a href="faqs.php">FAQs</a></li>
                        <li><a href="payment-options.php">Payment Options</a></li>
                        <li><a href="size-guide.php">Size Guide</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="privacy-policy.php">Privacy Policy</a></li>
                        <li><a href="terms-conditions.php">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="social-media.php">Facebook</a>
                        <a href="social-media.php">Instagram</a>
                        <a href="social-media.php">Twitter</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 YanKicks. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>