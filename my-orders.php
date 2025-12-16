<?php
session_start();
include 'api/db_connect.php';

// 1. Security: If not logged in, go to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login-register.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$account_link = 'account.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - YanKicks</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* CSS for Order Cards */
        .order-card { 
            background: #fff; 
            border: 1px solid #eee; 
            border-radius: 8px; 
            padding: 20px; 
            margin-bottom: 20px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
        }
        .order-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start;
            border-bottom: 1px solid #f0f0f0; 
            padding-bottom: 15px; 
            margin-bottom: 15px; 
        }
        .order-id { font-size: 18px; font-weight: bold; color: #333; }
        .order-date { color: #888; font-size: 14px; margin-top: 5px; }
        
        .status-badge { 
            padding: 6px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: bold; 
            color: white; 
            text-transform: uppercase; 
            display: inline-block;
        }
        .status-pending { background: #f39c12; }
        .status-shipped { background: #3498db; }
        .status-completed { background: #2ecc71; }
        .status-cancelled { background: #e74c3c; }

        .order-item-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 15px; color: #555; }
        .order-total { text-align: right; font-weight: bold; font-size: 18px; margin-top: 15px; color: #333; border-top: 1px solid #eee; padding-top: 15px;}
        
        .no-orders { text-align: center; padding: 40px; background: #f9f9f9; border-radius: 8px; color: #666; }
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
                <a href="<?php echo $account_link; ?>" class="account-btn" title="My Account">
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

    <main class="shop-page">
        <div class="container">
            <div class="shop-header">
                <h1>My Orders</h1>
                <p>View your order history and track shipments</p>
            </div>

            <div class="about-content">
                
                <?php
                // Fetch Orders for the logged-in user
                $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while($order = $result->fetch_assoc()) {
                        $order_id = $order['id'];
                        // Fetch Items for this order
                        $item_sql = "SELECT * FROM order_items WHERE order_id = ?";
                        $item_stmt = $conn->prepare($item_sql);
                        $item_stmt->bind_param("i", $order_id);
                        $item_stmt->execute();
                        $items = $item_stmt->get_result();
                        ?>
                        
                        <div class="order-card">
                            <div class="order-header">
                                <div>
                                    <div class="order-id">Order #<?php echo $order['id']; ?></div>
                                    <div class="order-date">Placed on <?php echo date('F d, Y', strtotime($order['created_at'])); ?></div>
                                </div>
                                <span class="status-badge status-<?php echo $order['status']; ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </div>

                            <div class="order-items-list">
                                <?php while($item = $items->fetch_assoc()): ?>
                                    <div class="order-item-row">
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
                    } 
                } else {
                    ?>
                    <div class="no-orders">
                        <h2>No orders found</h2>
                        <p>You haven't placed any orders yet.</p>
                        <a href="shop.php" class="hero-btn" style="display:inline-block; margin-top:15px; background:#333; color:white; padding:10px 20px; text-decoration:none; border-radius:4px;">Start Shopping</a>
                    </div>
                    <?php
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