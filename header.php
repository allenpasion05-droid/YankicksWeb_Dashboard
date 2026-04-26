<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$account_link = isset($_SESSION['user_id']) ? 'account.php' : 'login-register.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YanKicks - Premium Athletic Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .nav-link-active { border-bottom: 2px solid black; }
    </style>
</head>
<body class="bg-white text-black">
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <img src="assets/images/yankicks_logo.jpg" alt="YanKicks Logo" class="h-10 w-10 object-contain">
                    <span class="text-2xl font-extrabold tracking-tighter uppercase">YanKicks</span>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-sm font-semibold <?php echo $current_page == 'index.php' ? 'nav-link-active' : 'hover:text-gray-600'; ?> transition-colors">Home</a>
                    <a href="shop.php" class="text-sm font-semibold <?php echo $current_page == 'shop.php' ? 'nav-link-active' : 'hover:text-gray-600'; ?> transition-colors">Shop</a>
                    <a href="about.php" class="text-sm font-semibold <?php echo $current_page == 'about.php' ? 'nav-link-active' : 'hover:text-gray-600'; ?> transition-colors">About</a>
                    <a href="blog.php" class="text-sm font-semibold <?php echo $current_page == 'blog.php' ? 'nav-link-active' : 'hover:text-gray-600'; ?> transition-colors">Blog</a>
                    <a href="contact.php" class="text-sm font-semibold <?php echo $current_page == 'contact.php' ? 'nav-link-active' : 'hover:text-gray-600'; ?> transition-colors">Contact</a>
                </div>

                <div class="flex items-center gap-5">
                    <a href="<?php echo $account_link; ?>" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                    <button id="cartBtn" class="relative p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span id="cartCount" class="absolute top-0 right-0 bg-black text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">0</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Cart Sidebar (Simplified for now) -->
    <aside id="cartSidebar" class="fixed inset-y-0 right-0 w-full sm:w-96 bg-white shadow-2xl z-[60] transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="p-6 h-full flex flex-col">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold">Your Cart</h2>
                <button id="closeCart" class="p-2 hover:bg-gray-100 rounded-full">&times;</button>
            </div>
            <div id="cartItems" class="flex-1 overflow-y-auto space-y-4">
                <!-- Items will be injected here -->
            </div>
            <div class="border-t pt-6 mt-6">
                <div class="flex justify-between text-xl font-bold mb-6">
                    <span>Total</span>
                    <span id="cartTotal">₱0.00</span>
                </div>
                <button class="w-full bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-900 transition-colors">Checkout Now</button>
            </div>
        </div>
    </aside>
