<?php
session_start();
include 'api/db_connect.php';

// 1. Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login-register.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";
$message_type = "";

// --- HANDLER: FORM SUBMISSION --- //
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. UPDATE PROFILE INFO (Name, Email, Phone)
    $name = $_POST['settingsName'];
    $email = $_POST['settingsEmail'];
    $phone = $_POST['settingsPhone'];

    // Update basic info
    $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone_number=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $phone, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['user_name'] = $name; // Update session name immediately
        $message = "Profile details updated successfully.";
        $message_type = "success";
    } else {
        $message = "Error updating profile.";
        $message_type = "error";
    }

    // 2. HANDLE PROFILE PICTURE UPLOAD
    if (!empty($_FILES["profile_image"]["name"])) {
        $target_dir = "assets/images/users/";
        $file_extension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
        $new_filename = "user_" . $user_id . "_" . time() . "." . $file_extension; // Unique name
        $target_file = $target_dir . $new_filename;
        
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        
        if($check !== false) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                // Update DB with new image path
                $stmt_img = $conn->prepare("UPDATE users SET profile_picture=? WHERE id=?");
                $stmt_img->bind_param("si", $target_file, $user_id);
                $stmt_img->execute();
                $message = "Profile and Photo updated!";
            } else {
                $message = "Error uploading image.";
                $message_type = "error";
            }
        }
    }

    // 3. HANDLE PASSWORD CHANGE (Only if fields are filled)
    if (!empty($_POST['currentPassword']) && !empty($_POST['newPassword'])) {
        $current_pass = $_POST['currentPassword'];
        $new_pass = $_POST['newPassword'];
        $confirm_pass = $_POST['confirmPassword'];

        // Get current hash
        $stmt_pass = $conn->prepare("SELECT password FROM users WHERE id=?");
        $stmt_pass->bind_param("i", $user_id);
        $stmt_pass->execute();
        $res_pass = $stmt_pass->get_result()->fetch_assoc();

        if (password_verify($current_pass, $res_pass['password'])) {
            if ($new_pass === $confirm_pass) {
                $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
                $stmt_update_pass = $conn->prepare("UPDATE users SET password=? WHERE id=?");
                $stmt_update_pass->bind_param("si", $new_hash, $user_id);
                $stmt_update_pass->execute();
                $message = "Profile and Password updated successfully!";
            } else {
                $message = "New passwords do not match.";
                $message_type = "error";
            }
        } else {
            $message = "Current password is incorrect.";
            $message_type = "error";
        }
    }
}

// FETCH USER DETAILS TO FILL FORM
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Default Image Logic
$profile_pic = !empty($user['profile_picture']) ? $user['profile_picture'] : "assets/images/yankicks_logo.jpg"; // Fallback image
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - YanKicks</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Alert Styles */
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* Profile Pic Styles matching your layout */
        .profile-upload-section { text-align: center; margin-bottom: 30px; }
        .profile-img-preview { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #eee; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto;}
        .file-upload-wrapper { position: relative; overflow: hidden; display: inline-block; }
        .btn-upload { border: 1px solid #ccc; color: #333; background-color: white; padding: 6px 12px; border-radius: 4px; font-size: 14px; cursor: pointer; }
        .file-upload-wrapper input[type=file] { font-size: 100px; position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer; }
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

    <main class="contact-page">
        <div class="container">
            <div class="contact-header">
                <h1>Account Settings</h1>
                <p>Update your profile and preferences</p>
                
                <?php if($message): ?>
                    <div class="alert alert-<?php echo $message_type; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="contact-content">
                <form class="contact-form" id="settingsForm" method="POST" enctype="multipart/form-data">
                    
                    <div class="profile-upload-section">
                        <img src="<?php echo $profile_pic; ?>" alt="Profile" class="profile-img-preview">
                        <div class="file-upload-wrapper">
                            <button class="btn-upload">Change Photo</button>
                            <input type="file" name="profile_image" accept="image/*">
                        </div>
                    </div>

                    <h2>Profile Information</h2>
                    <div class="form-group">
                        <label for="settingsName">Full Name</label>
                        <input type="text" id="settingsName" name="settingsName" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="settingsEmail">Email Address</label>
                        <input type="email" id="settingsEmail" name="settingsEmail" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="settingsPhone">Phone Number</label>
                        <input type="tel" id="settingsPhone" name="settingsPhone" value="<?php echo isset($user['phone_number']) ? htmlspecialchars($user['phone_number']) : ''; ?>">
                    </div>

                    <h2 style="margin-top: 30px;">Change Password</h2>
                    <p style="font-size: 14px; color: #666; margin-bottom: 15px;">Leave these blank if you don't want to change your password.</p>
                    
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" id="currentPassword" name="currentPassword">
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" id="newPassword" name="newPassword">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword">
                    </div>

                    <button type="submit" class="submit-btn">Save Changes</button>
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
</body>
</html>