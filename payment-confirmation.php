<?php
session_start();
$account_link = isset($_SESSION['user_id']) ? 'account.php' : 'login-register.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - YanKicks</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .confirmation-container {
            max-width: 600px;
            margin: 80px auto;
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .success-icon {
            color: #27ae60;
            margin-bottom: 20px;
        }
        .order-details {
            margin: 30px 0;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }
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

    <main class="shop-page">
        <div class="container">
            <div class="confirmation-container">
                <div class="success-icon">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <h1>Order Placed Successfully!</h1>
                <p>Thank you for shopping with YanKicks. Your order has been received and is being processed.</p>
                
                <?php if(isset($_GET['order_id'])): ?>
                <div class="order-details">
                    <p><strong>Order Reference:</strong> #<?php echo htmlspecialchars($_GET['order_id']); ?></p>
                    <p>You will receive an email confirmation shortly.</p>
                </div>
                <?php endif; ?>

                <a href="shop.php" class="hero-btn">Continue Shopping</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2023 YanKicks. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Clear the cart data from Local Storage
            localStorage.removeItem('yankicks_cart');

            // 2. Visually reset the cart count to 0
            const cartCountElement = document.getElementById('cartCount');
            if (cartCountElement) {
                cartCountElement.innerText = '0';
            }
            
            console.log("Cart has been cleared following successful checkout.");
        });
    </script>
</body>
</html>