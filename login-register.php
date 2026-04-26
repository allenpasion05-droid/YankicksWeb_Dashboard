<?php
session_start();

// IF USER IS ALREADY LOGGED IN, REDIRECT TO ACCOUNT DASHBOARD
if (isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

$account_link = 'login-register.php'; // Since we are on the login page
?>

<?php include 'header.php'; ?>

<main>
    <!-- Auth Hero -->
    <section class="relative h-[40vh] flex items-center overflow-hidden bg-black">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/60 to-transparent z-10"></div>
            <img src="assets/images/yankicks_logo.jpg" alt="Login/Register" class="w-full h-full object-cover object-center opacity-30 scale-110 animate-pulse-slow">
        </div>
        
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-3xl space-y-8">
                <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter leading-none">
                    Welcome <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">Back</span>
                </h1>
                <p class="text-xl text-gray-300 font-medium max-w-lg">
                    Sign in to your account or create a new one to access exclusive features.
                </p>
            </div>
        </div>
    </section>

    <!-- Auth Forms -->
    <section class="py-32 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20">
                <!-- Login Form -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-4xl font-black uppercase tracking-tighter mb-6">Sign In</h2>
                        <p class="text-gray-600 text-lg">Welcome back! Please sign in to your account.</p>
                    </div>

                    <form class="space-y-6" id="loginForm" action="login.php" method="POST">
                        <div>
                            <label class="block text-sm font-bold uppercase tracking-widest text-gray-400 mb-2">Email Address</label>
                            <input type="email" name="email" required class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 text-lg focus:ring-2 focus:ring-black transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold uppercase tracking-widest text-gray-400 mb-2">Password</label>
                            <input type="password" name="password" required class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 text-lg focus:ring-2 focus:ring-black transition-all">
                        </div>
                        <button type="submit" class="w-full bg-black text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-gray-900 transition-all transform hover:scale-105">Sign In</button>
                    </form>
                </div>

                <!-- Register Form -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-4xl font-black uppercase tracking-tighter mb-6">Create Account</h2>
                        <p class="text-gray-600 text-lg">Join YanKicks and get access to exclusive deals and features.</p>
                    </div>

                    <form class="space-y-6" id="registerForm" action="register.php" method="POST">
                        <div>
                            <label class="block text-sm font-bold uppercase tracking-widest text-gray-400 mb-2">Full Name</label>
                            <input type="text" name="full_name" required class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 text-lg focus:ring-2 focus:ring-black transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold uppercase tracking-widest text-gray-400 mb-2">Email Address</label>
                            <input type="email" name="email" required class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 text-lg focus:ring-2 focus:ring-black transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold uppercase tracking-widest text-gray-400 mb-2">Password</label>
                            <input type="password" name="password" required class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 text-lg focus:ring-2 focus:ring-black transition-all">
                        </div>
                        <button type="submit" class="w-full bg-black text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-gray-900 transition-all transform hover:scale-105">Create Account</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>