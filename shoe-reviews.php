<?php
session_start();
$account_link = isset($_SESSION['user_id']) ? 'account.php' : 'login-register.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Reviews - YanKicks Blog</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Review Card Styling */
        .review-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            transition: transform 0.2s;
        }
        .review-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        .review-title {
            font-size: 1.4rem;
            font-weight: bold;
            margin: 0;
        }
        .review-rating {
            color: #f1c40f; /* Gold color for stars */
            font-size: 1.2rem;
        }
        .review-meta {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 15px;
            font-style: italic;
        }
        .review-content {
            line-height: 1.6;
            color: #444;
        }
        .pros-cons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .pros, .cons {
            flex: 1;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            min-width: 200px;
        }
        .pros h4 { color: #27ae60; margin-top: 0; margin-bottom: 10px; }
        .cons h4 { color: #c0392b; margin-top: 0; margin-bottom: 10px; }
        .pros ul, .cons ul { margin: 0; padding-left: 20px; }
        
        .buy-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .buy-btn:hover { background: #333; }

        /* Video Container */
        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            margin-bottom: 40px;
            border-radius: 8px;
            overflow: hidden;
        }
        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
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
                <h1>Shoe Reviews</h1>
                <p>In-depth hands-on reviews of our latest collection</p>
            </div>

            <div class="about-content">
                
                <div class="about-section">
                    <h2>Featured Video Review</h2>
                    <p>Check out this breakdown of the best daily trainers for 2024, featuring similar technology to our Velocity Elite series.</p>
                    <div class="video-wrapper">
                        <iframe src="https://www.youtube.com/embed/yjtc-rS8EH8" title="The Best Daily Running Shoes 2024" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="about-section">
                    <h2>Latest Reviews</h2>

                    <div class="review-card">
                        <div class="review-header">
                            <h3 class="review-title">Velocity Elite - The Speed Demon</h3>
                            <div class="review-rating">★★★★★ (5.0)</div>
                        </div>
                        <div class="review-meta">Tested by: Mark D. | Terrain: Road/Track | Distance: 50km</div>
                                                <div class="review-content">
                            <p>The Velocity Elite is designed for one thing: speed. From the moment you lace them up, the energy return from the midsole is noticeable. The upper mesh is extremely breathable, making it perfect for long runs in the Philippine heat.</p>
                        </div>
                        <div class="pros-cons">
                            <div class="pros">
                                <h4>Pros</h4>
                                <ul>
                                    <li>Incredible energy return</li>
                                    <li>Very lightweight</li>
                                    <li>Breathable upper</li>
                                </ul>
                            </div>
                            <div class="cons">
                                <h4>Cons</h4>
                                <ul>
                                    <li>Runs slightly narrow</li>
                                    <li>Price point is premium</li>
                                </ul>
                            </div>
                        </div>
                        <a href="shop.php" class="buy-btn">Shop Velocity Elite</a>
                    </div>

                    <div class="review-card">
                        <div class="review-header">
                            <h3 class="review-title">TrailBlazer X - Conquer Any Path</h3>
                            <div class="review-rating">★★★★☆ (4.5)</div>
                        </div>
                        <div class="review-meta">Tested by: Sarah L. | Terrain: Rocky/Mud | Distance: 30km</div>
                                                <div class="review-content">
                            <p>If you love hiking in Laguna or Batangas, the TrailBlazer X is your best friend. The grip is phenomenal on wet rocks, and the ankle support gives you confidence on uneven descents. It's a bit heavier than a standard runner, but the protection is worth it.</p>
                        </div>
                        <div class="pros-cons">
                            <div class="pros">
                                <h4>Pros</h4>
                                <ul>
                                    <li>Superior grip</li>
                                    <li>Water-resistant coating</li>
                                    <li>Excellent ankle stability</li>
                                </ul>
                            </div>
                            <div class="cons">
                                <h4>Cons</h4>
                                <ul>
                                    <li>Heavier than average</li>
                                    <li>Break-in period required</li>
                                </ul>
                            </div>
                        </div>
                        <a href="shop.php" class="buy-btn">Shop TrailBlazer X</a>
                    </div>

                    <div class="review-card">
                        <div class="review-header">
                            <h3 class="review-title">StreetStyle Signature - Everyday Comfort</h3>
                            <div class="review-rating">★★★★☆ (4.8)</div>
                        </div>
                        <div class="review-meta">Tested by: YanKicks Team | Use: Daily Casual</div>
                        <div class="review-content">
                            <p>The StreetStyle Signature balances retro aesthetics with modern comfort foam. It's the shoe you wear when you want to look good at the mall or the office without sacrificing your feet. The leather quality is surprisingly soft for the price point.</p>
                        </div>
                        <a href="shop.php" class="buy-btn">Shop StreetStyle</a>
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
                <p>&copy; 2023 YanKicks. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>