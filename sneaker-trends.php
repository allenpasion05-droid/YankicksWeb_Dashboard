<?php
session_start();
$account_link = isset($_SESSION['user_id']) ? 'account.php' : 'login-register.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Trends 2025 - YanKicks Blog</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Responsive Video Container */
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
            border-radius: 8px;
            margin-top: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
        
        .trend-card {
            background: #fff;
            border: 1px solid #eee;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .trend-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .trend-link {
            color: #000;
            font-weight: bold;
            text-decoration: underline;
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

    <main class="blog-page">
        <div class="container">
            <div class="page-header">
                <h1>Sneaker Trends 2025</h1>
                <p>Stay ahead of the curve with the latest footwear styles</p>
            </div>

            <div class="about-content">
                <div class="about-section">
                    <h2>What's Trending Now in 2025</h2>
                    <p>The sneaker landscape for 2025 is blending futuristic tech with nostalgic comfort. Discover the key trends shaping the industry this year.</p>
                    
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/CWpqteqbvQ8" title="Sneaker Trends 2025" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="about-section">
                    <h2>Key Styles to Watch</h2>
                    
                    <div class="trend-card">
                        <h3>1. Y2K Tech Runners</h3>
                        <p>The early 2000s aesthetic is evolving. Look for mesh uppers, metallic overlays, and aggressive midsole designs that mimic the "tech runner" vibe of the millennium turn.</p>
                        <br>
                        
                        <br><br>
                        <a href="shop.php" class="trend-link">Shop Tech Runners &rarr;</a>
                    </div>

                    <div class="trend-card">
                        <h3>2. Sustainable Performance</h3>
                        <p>Eco-friendly isn't just a niche anymore; it's the standard. 2025 sees major strides in bio-based foams and recycled knit uppers that don't compromise on performance or durability.</p>
                        <a href="shop.php" class="trend-link">Browse Sustainable Collection &rarr;</a>
                    </div>

                    <div class="trend-card">
                        <h3>3. Streamlined Silhouettes</h3>
                        <p>Moving away from the ultra-chunky "dad shoe," 2025 favors sleeker, more aerodynamic profiles. Think low-profile court shoes and slim racing flats adapted for the street.</p>
                        <a href="shop.php" class="trend-link">Check Out Slim Styles &rarr;</a>
                    </div>

                    <div class="trend-card">
                        <h3>4. Earth Tones & Gorpcore</h3>
                        <p>The outdoors continues to influence street fashion. Muted olives, browns, and trail-ready rugged outsoles are dominating, blurring the line between hiking gear and city wear.</p>
                        <a href="shop.php" class="trend-link">View Outdoor & Trail &rarr;</a>
                    </div>
                </div>
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
                <p>&copy; 2025 YanKicks. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>