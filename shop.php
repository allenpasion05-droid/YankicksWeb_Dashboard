<?php include 'header.php'; ?>

<main class="py-20 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Shop Header -->
        <div class="mb-16 text-center">
            <h1 class="text-6xl font-black uppercase tracking-tighter mb-4">All Products</h1>
            <p class="text-gray-500 text-lg max-w-2xl mx-auto">Discover our complete collection of premium athletic footwear. Engineered for speed, built for performance.</p>
        </div>

        <!-- Filters Section -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-16 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex flex-wrap gap-6 items-center">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 ml-1">Category</label>
                    <select id="categoryFilter" class="block w-48 bg-gray-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-black transition-all">
                        <option value="all">All Categories</option>
                        <option value="Running">Running</option>
                        <option value="Basketball">Basketball</option>
                        <option value="Lifestyle">Lifestyle</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 ml-1">Sort By</label>
                    <select id="priceFilter" class="block w-48 bg-gray-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-black transition-all">
                        <option value="default">Newest First</option>
                        <option value="low-high">Price: Low to High</option>
                        <option value="high-low">Price: High to Low</option>
                    </select>
                </div>
            </div>
            <div class="text-sm font-bold text-gray-400">
                Showing <span id="productCount" class="text-black">0</span> products
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10" id="productsGrid">
            <!-- Loading State -->
            <div class="col-span-full py-20 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-black border-t-transparent mb-4"></div>
                <p class="text-gray-500 font-bold">Loading premium kicks...</p>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<script>
    let allProducts = [];

    document.addEventListener('DOMContentLoaded', () => {
        const grid = document.getElementById('productsGrid');
        const categorySelect = document.getElementById('categoryFilter');
        const priceSelect = document.getElementById('priceFilter');
        const countDisplay = document.getElementById('productCount');

        // Fetch Products
        fetch('api/products.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                allProducts = data;
                applyFilters();
            })
            .catch(err => {
                console.error('Error loading products:', err);
                grid.innerHTML = '<div class="col-span-full py-20 text-center text-red-500 font-bold">Unable to load products. Please check your connection and try again later.</div>';
                countDisplay.textContent = '0';
            });

        categorySelect.addEventListener('change', applyFilters);
        priceSelect.addEventListener('change', applyFilters);

        function applyFilters() {
            let result = [...allProducts];

            const category = categorySelect.value;
            if (category !== 'all') {
                result = result.filter(p => p.category.toLowerCase() === category.toLowerCase());
            }

            const sortType = priceSelect.value;
            if (sortType === 'low-high') {
                result.sort((a, b) => parseFloat(a.price) - parseFloat(b.price));
            } else if (sortType === 'high-low') {
                result.sort((a, b) => parseFloat(b.price) - parseFloat(a.price));
            }

            countDisplay.textContent = result.length;
            displayProducts(result);
        }

        function displayProducts(products) {
            if (products.length === 0) {
                grid.innerHTML = '<div class="col-span-full py-20 text-center text-gray-500 font-bold">No products match your selection.</div>';
                return;
            }

            grid.innerHTML = products.map(p => `
                <div class="group bg-white rounded-[2.5rem] p-6 border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                    <div class="relative aspect-square rounded-[2rem] overflow-hidden bg-gray-50 mb-8">
                        <img src="assets/images/${p.image.replace('uploads/', '')}" alt="${p.name}" onerror="this.src='assets/images/yankicks_logo.jpg'" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm">
                            ${p.category}
                        </div>
                        <button onclick="addToCart(${p.id})" class="absolute bottom-4 right-4 bg-black text-white p-4 rounded-2xl opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 shadow-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </button>
                    </div>
                    <div class="px-2">
                        <h3 class="text-xl font-bold mb-2 group-hover:text-gray-600 transition-colors">${p.name}</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-black">₱${parseFloat(p.price).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">In Stock</span>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    });
</script>
