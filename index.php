<?php include 'header.php'; ?>

<main>
    <!-- Hero Section -->
    <section class="relative h-[90vh] flex items-center overflow-hidden bg-black">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/60 to-transparent z-10"></div>
            <img src="assets/images/cloudrunelite_shop.jpg" alt="Hero Shoe" class="w-full h-full object-cover object-center opacity-70 scale-110 animate-pulse-slow">
        </div>
        
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-2xl space-y-8">
                <h1 class="text-7xl md:text-9xl font-black text-white uppercase tracking-tighter leading-none">
                    Just <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">Do It.</span>
                </h1>
                <p class="text-xl text-gray-300 font-medium max-w-lg">
                    Experience Premium Athletic Footwear Designed for Champions. Engineered for speed, built for performance.
                </p>
                <div class="flex gap-4">
                    <a href="shop.php" class="bg-white text-black px-10 py-5 rounded-full font-bold text-lg hover:bg-gray-200 transition-all transform hover:scale-105">Shop Collection</a>
                    <a href="about.php" class="border-2 border-white text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-white hover:text-black transition-all">Our Story</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Collections -->
    <section class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-16">
                <div>
                    <h2 class="text-5xl font-black uppercase tracking-tighter">Featured Collections</h2>
                    <p class="text-gray-500 mt-4 text-lg">Curated selections for every athlete.</p>
                </div>
                <a href="shop.php" class="text-black font-bold border-b-2 border-black pb-1 hover:text-gray-600 hover:border-gray-600 transition-all">View All Products</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="group cursor-pointer">
                    <div class="relative aspect-[4/5] overflow-hidden rounded-3xl bg-gray-100">
                        <img src="assets/images/running1.jpg" alt="Running" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-all"></div>
                        <div class="absolute bottom-10 left-10 text-white">
                            <h3 class="text-3xl font-bold uppercase">Running</h3>
                            <p class="text-gray-200 mt-2">Engineered for speed</p>
                        </div>
                    </div>
                </div>
                <div class="group cursor-pointer">
                    <div class="relative aspect-[4/5] overflow-hidden rounded-3xl bg-gray-100">
                        <img src="assets/images/basketball4.jpg" alt="Basketball" onerror="this.src='assets/images/yankicks_logo.jpg'" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-all"></div>
                        <div class="absolute bottom-10 left-10 text-white">
                            <h3 class="text-3xl font-bold uppercase">Basketball</h3>
                            <p class="text-gray-200 mt-2">Built for the court</p>
                        </div>
                    </div>
                </div>
                <div class="group cursor-pointer">
                    <div class="relative aspect-[4/5] overflow-hidden rounded-3xl bg-gray-100">
                        <img src="assets/images/lifestyle2.jpg" alt="Lifestyle" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-all"></div>
                        <div class="absolute bottom-10 left-10 text-white">
                            <h3 class="text-3xl font-bold uppercase">Lifestyle</h3>
                            <p class="text-gray-200 mt-2">Everyday style</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-32 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-center">
                <div class="space-y-10">
                    <h2 class="text-5xl font-black uppercase tracking-tighter leading-tight">Why Choose <br> YanKicks?</h2>
                    <div class="space-y-8">
                        <div class="flex gap-6">
                            <div class="flex-shrink-0 w-14 h-14 bg-black text-white rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">Premium Quality</h4>
                                <p class="text-gray-500 mt-2">Crafted with the finest materials and cutting-edge technology for maximum durability.</p>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <div class="flex-shrink-0 w-14 h-14 bg-black text-white rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">Innovative Design</h4>
                                <p class="text-gray-500 mt-2">Combining urban style with unmatched performance to keep you ahead of the game.</p>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <div class="flex-shrink-0 w-14 h-14 bg-black text-white rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">Sustainability</h4>
                                <p class="text-gray-500 mt-2">Committed to ethical production practices and reducing our environmental footprint.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-square rounded-full bg-black/5 absolute -top-10 -right-10 w-full h-full -z-10"></div>
                    <img src="assets/images/yankicks_logo.jpg" alt="YanKicks Brand" class="w-full rounded-3xl shadow-2xl transform -rotate-3 hover:rotate-0 transition-transform duration-500">
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
