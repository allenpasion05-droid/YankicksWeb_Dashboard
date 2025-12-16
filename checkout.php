<?php
session_start();
$account_link = isset($_SESSION['user_id']) ? 'account.php' : 'login-register.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - YanKicks</title>
    <link rel="stylesheet" href="styles.css">
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

    <main class="contact-page">
        <div class="container">
            <div class="contact-header">
                <h1>Checkout</h1>
                <p>Complete your purchase</p>
            </div>

            <div class="contact-content">
                <div style="margin-bottom: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px;">
                    <h2>Order Summary</h2>
                    <div id="checkoutSummaryItems">Loading items...</div>
                    <hr style="margin: 15px 0; border: 0; border-top: 1px solid #ddd;">
                    <h3>Total: <span id="checkoutPageTotal">₱0.00</span></h3>
                </div>

                <form class="contact-form" id="checkoutForm" action="place_order.php" method="POST">
                    
                    <input type="hidden" name="cart_data" id="cartDataField">

                    <h2>Shipping Information</h2>
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Full Address (Include City & Zip)</label>
                        <input type="text" id="address" name="address" required>
                    </div>

                    <h2 style="margin-top: 30px;">Payment Method</h2>
                    <div class="form-group">
                        <label for="paymentMethod">Select Payment</label>
                        <select id="paymentMethod" name="payment_method" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" onchange="togglePaymentFields()">
                            <option value="GCash">GCash (e-Wallet)</option>
                            <option value="COD">Cash on Delivery</option>
                            <option value="Card">Credit/Debit Card</option>
                        </select>
                    </div>

                    <div id="cardFields" style="display:none;">
                        <div class="form-group">
                            <label for="cardNumber">Card Number</label>
                            <input type="text" id="cardNumber" name="cardNumber">
                        </div>
                        <div class="form-group">
                            <label for="expiryDate">Expiry Date</label>
                            <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY">
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv">
                        </div>
                    </div>

                    <div id="gcashFields" style="display:block; background:#e6f7ff; padding:15px; border-radius:4px; margin-bottom:20px;">
                        <p><strong>GCash Number:</strong> 0917-123-4567</p>
                        <p>Please send the exact amount and save your screenshot.</p>
                    </div>

                    <button type="submit" class="submit-btn">Complete Purchase</button>
                </form>
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

    <script>
        // 1. Get Elements
        const cartDataField = document.getElementById('cartDataField');
        const summaryDiv = document.getElementById('checkoutSummaryItems');
        const totalSpan = document.getElementById('checkoutPageTotal');
        
        // 2. Load Cart
        const myCart = JSON.parse(localStorage.getItem('yankicks_cart')) || [];
        
        // 3. Inject Cart JSON into hidden input (CRITICAL FOR PHP)
        cartDataField.value = JSON.stringify(myCart);

        // 4. Show visual summary
        if (myCart.length === 0) {
            summaryDiv.innerHTML = "<p>Your cart is empty.</p>";
        } else {
            let html = "";
            let grandTotal = 0;
            myCart.forEach(item => {
                let itemTotal = item.price * item.quantity;
                grandTotal += itemTotal;
                html += `<div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                            <span>${item.name} x ${item.quantity}</span>
                            <span>₱${itemTotal.toLocaleString()}</span>
                         </div>`;
            });
            summaryDiv.innerHTML = html;
            totalSpan.innerText = "₱" + grandTotal.toLocaleString();
        }

        // 5. Toggle Payment Fields (Visual only)
        function togglePaymentFields() {
            const method = document.getElementById('paymentMethod').value;
            const cardDiv = document.getElementById('cardFields');
            const gcashDiv = document.getElementById('gcashFields');

            if (method === 'Card') {
                cardDiv.style.display = 'block';
                gcashDiv.style.display = 'none';
            } else if (method === 'GCash') {
                cardDiv.style.display = 'none';
                gcashDiv.style.display = 'block';
            } else {
                // COD
                cardDiv.style.display = 'none';
                gcashDiv.style.display = 'none';
            }
        }
        
        // Clear cart after successful submit
        document.getElementById('checkoutForm').addEventListener('submit', function() {
            // Optional: You can clear localStorage here if you assume PHP will succeed
            // localStorage.removeItem('yankicks_cart');
        });
    </script>
</body>
</html>