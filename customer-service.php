<?php include 'header.php'; ?>

<main>
    <!-- Customer Service Hero -->
    <section class="relative h-[50vh] flex items-center overflow-hidden bg-black">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/60 to-transparent z-10"></div>
            <img src="assets/images/running_shoes.jpeg" alt="Customer Service" class="w-full h-full object-cover object-center opacity-50 scale-110 animate-pulse-slow">
        </div>
        
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-3xl space-y-8">
                <h1 class="text-6xl md:text-8xl font-black text-white uppercase tracking-tighter leading-none">
                    Customer <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">Service</span>
                </h1>
                <p class="text-xl text-gray-300 font-medium max-w-lg">
                    We're here to help you with any questions or concerns. Get the support you need.
                </p>
            </div>
        </div>
    </section>

    <!-- Service Links -->
    <section class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-black uppercase tracking-tighter mb-6">How Can We Help?</h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Find answers to your questions and get the assistance you need.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <a href="shipping-delivery.php" class="group bg-gray-50 rounded-3xl p-8 hover:bg-black hover:text-white transition-all duration-500 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white group-hover:text-black transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Shipping & Delivery</h3>
                    <p class="text-gray-600 group-hover:text-gray-300 transition-colors">Learn about our shipping options and delivery times for your orders.</p>
                </a>

                <a href="returns-exchange.php" class="group bg-gray-50 rounded-3xl p-8 hover:bg-black hover:text-white transition-all duration-500 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white group-hover:text-black transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Returns & Exchange</h3>
                    <p class="text-gray-600 group-hover:text-gray-300 transition-colors">Understand our return and exchange process and policies.</p>
                </a>

                <a href="faqs.php" class="group bg-gray-50 rounded-3xl p-8 hover:bg-black hover:text-white transition-all duration-500 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white group-hover:text-black transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">FAQs</h3>
                    <p class="text-gray-600 group-hover:text-gray-300 transition-colors">Find answers to frequently asked questions about our products and services.</p>
                </a>

                <a href="payment-options.php" class="group bg-gray-50 rounded-3xl p-8 hover:bg-black hover:text-white transition-all duration-500 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white group-hover:text-black transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Payment Options</h3>
                    <p class="text-gray-600 group-hover:text-gray-300 transition-colors">See all available payment methods and secure checkout options.</p>
                </a>

                <a href="size-guide.php" class="group bg-gray-50 rounded-3xl p-8 hover:bg-black hover:text-white transition-all duration-500 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white group-hover:text-black transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Size Guide</h3>
                    <p class="text-gray-600 group-hover:text-gray-300 transition-colors">Find the perfect fit for your feet with our comprehensive size guide.</p>
                </a>

                <a href="contact.php" class="group bg-gray-50 rounded-3xl p-8 hover:bg-black hover:text-white transition-all duration-500 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white group-hover:text-black transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Contact Us</h3>
                    <p class="text-gray-600 group-hover:text-gray-300 transition-colors">Get in touch with our customer service team for personalized assistance.</p>
                </a>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>