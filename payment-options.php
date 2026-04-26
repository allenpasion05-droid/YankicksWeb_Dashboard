<?php include 'header.php'; ?>

<main>
    <!-- Payment Options Hero -->
    <section class="relative h-[70vh] flex items-center overflow-hidden bg-black">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/60 to-transparent z-10"></div>
            <img src="assets/images/yankicks_logo.jpg" alt="Payment Options" class="w-full h-full object-cover object-center opacity-50 scale-110 animate-pulse-slow">
        </div>

        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-3xl space-y-8">
                <h1 class="text-6xl md:text-8xl font-black text-white uppercase tracking-tighter leading-none">
                    Payment <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">Options</span>
                </h1>
                <p class="text-xl text-gray-300 font-medium max-w-lg">
                    Secure and Convenient Payment Methods. Shop with Confidence.
                </p>
            </div>
        </div>
    </section>

    <!-- Payment Methods -->
    <section class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-black uppercase tracking-tighter leading-tight">Accepted Payment Methods</h2>
                <p class="text-gray-500 mt-4 text-lg">Multiple secure payment options for your convenience</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
                <div class="bg-gray-50 p-8 rounded-3xl text-center">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-lg">GC</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">GCash</h3>
                    <p class="text-gray-600">Fast and secure mobile wallet payments</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-3xl text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Credit Cards</h3>
                    <p class="text-gray-600">Visa, Mastercard, American Express</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-3xl text-center">
                    <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Debit Cards</h3>
                    <p class="text-gray-600">All major debit cards accepted</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-3xl text-center">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold text-lg">PP</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">PayPal</h3>
                    <p class="text-gray-600">Fast and secure PayPal payments</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-3xl text-center">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Bank Transfer</h3>
                    <p class="text-gray-600">Direct bank transfer available</p>
                </div>

                <div class="bg-gray-50 p-8 rounded-3xl text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Digital Wallets</h3>
                    <p class="text-gray-600">Apple Pay, Google Pay, Maya</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <div class="space-y-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold">Security</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed text-lg">All payments are processed through secure, encrypted channels. We never store your full credit card information on our servers.</p>
                </div>

                <div class="space-y-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold">Payment Processing</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed text-lg">Payments are processed immediately upon checkout. You will receive a confirmation email once your payment is successfully processed.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>