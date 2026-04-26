<?php include 'header.php'; ?>

<main>
    <!-- Shipping & Delivery Hero -->
    <section class="relative h-[70vh] flex items-center overflow-hidden bg-black">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/60 to-transparent z-10"></div>
            <img src="assets/images/yankicks_logo.jpg" alt="Shipping & Delivery" class="w-full h-full object-cover object-center opacity-50 scale-110 animate-pulse-slow">
        </div>

        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-3xl space-y-8">
                <h1 class="text-6xl md:text-8xl font-black text-white uppercase tracking-tighter leading-none">
                    Shipping & <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">Delivery</span>
                </h1>
                <p class="text-xl text-gray-300 font-medium max-w-lg">
                    Fast, Reliable Shipping Worldwide. Get Your YanKicks Delivered Quickly and Safely.
                </p>
            </div>
        </div>
    </section>

    <!-- Shipping Information -->
    <section class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-black uppercase tracking-tighter leading-tight">Shipping Options</h2>
                <p class="text-gray-500 mt-4 text-lg">Choose the delivery method that works best for you</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
                <div class="bg-gray-50 p-6 rounded-3xl text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Standard Shipping</h3>
                    <p class="text-gray-600 mb-2">5-7 business days</p>
                    <p class="text-2xl font-bold text-black">₱150.00</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-3xl text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Express Shipping</h3>
                    <p class="text-gray-600 mb-2">2-3 business days</p>
                    <p class="text-2xl font-bold text-black">₱300.00</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-3xl text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Overnight Shipping</h3>
                    <p class="text-gray-600 mb-2">Next business day</p>
                    <p class="text-2xl font-bold text-black">₱600.00</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-3xl text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Free Shipping</h3>
                    <p class="text-gray-600 mb-2">Orders over ₱30,000</p>
                    <p class="text-2xl font-bold text-green-600">FREE</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold">Processing Time</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">Orders are typically processed within 1-2 business days. During peak seasons, processing may take up to 3 business days.</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold">International Shipping</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">We ship worldwide! International shipping rates and delivery times vary by location. Please contact us for specific international shipping information.</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold">Track Your Order</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">Once your order ships, you'll receive a tracking number via email. You can use this to track your package in real-time.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>