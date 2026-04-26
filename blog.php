<?php include 'header.php'; ?>

<main>
    <!-- Blog Hero -->
    <section class="relative h-[60vh] flex items-center overflow-hidden bg-black">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/60 to-transparent z-10"></div>
            <img src="assets/images/basketball_shoes.jpg" alt="YanKicks Blog" class="w-full h-full object-cover object-center opacity-50 scale-110 animate-pulse-slow">
        </div>
        
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-3xl space-y-8">
                <h1 class="text-6xl md:text-8xl font-black text-white uppercase tracking-tighter leading-none">
                    YanKicks <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">Blog</span>
                </h1>
                <p class="text-xl text-gray-300 font-medium max-w-lg">
                    Stay updated with the latest trends, guides, and reviews in athletic footwear.
                </p>
            </div>
        </div>
    </section>

    <!-- Blog Categories -->
    <section class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-black uppercase tracking-tighter mb-6">Explore Our Content</h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Discover insights, trends, and expert advice from the world of athletic footwear.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <a href="sneaker-trends.php" class="group bg-gray-50 rounded-3xl p-8 hover:bg-black hover:text-white transition-all duration-500 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white group-hover:text-black transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Sneaker Trends</h3>
                    <p class="text-gray-600 group-hover:text-gray-300 transition-colors">Discover the latest trends in sneaker culture and streetwear fashion.</p>
                </a>

                <a href="shoe-guide.php" class="group bg-gray-50 rounded-3xl p-8 hover:bg-black hover:text-white transition-all duration-500 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white group-hover:text-black transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Shoe Guide</h3>
                    <p class="text-gray-600 group-hover:text-gray-300 transition-colors">Comprehensive guides to choosing the right shoes for your needs.</p>
                </a>

                <a href="shoe-reviews.php" class="group bg-gray-50 rounded-3xl p-8 hover:bg-black hover:text-white transition-all duration-500 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white group-hover:text-black transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Shoe Reviews</h3>
                    <p class="text-gray-600 group-hover:text-gray-300 transition-colors">In-depth reviews of our premium footwear collection.</p>
                </a>

                <a href="featured-brands.php" class="group bg-gray-50 rounded-3xl p-8 hover:bg-black hover:text-white transition-all duration-500 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white group-hover:text-black transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Featured Brands</h3>
                    <p class="text-gray-600 group-hover:text-gray-300 transition-colors">Learn about our featured brands and partnerships.</p>
                </a>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>