// Modern Cart Logic for YanKicks
let cart = JSON.parse(localStorage.getItem('yankicks_cart')) || [];

document.addEventListener('DOMContentLoaded', () => {
    const cartBtn = document.getElementById('cartBtn');
    const closeCart = document.getElementById('closeCart');
    const cartSidebar = document.getElementById('cartSidebar');
    const cartCount = document.getElementById('cartCount');
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');

    // Toggle Cart Sidebar
    if (cartBtn) {
        cartBtn.addEventListener('click', () => {
            cartSidebar.classList.remove('translate-x-full');
            updateCartUI();
        });
    }

    if (closeCart) {
        closeCart.addEventListener('click', () => {
            cartSidebar.classList.add('translate-x-full');
        });
    }

    // Update Cart UI
    window.updateCartUI = () => {
        if (!cartItems) return;

        if (cart.length === 0) {
            cartItems.innerHTML = `
                <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    <p class="font-bold">Your cart is empty</p>
                </div>
            `;
            cartTotal.textContent = '₱0.00';
            cartCount.textContent = '0';
            return;
        }

        let total = 0;
        cartItems.innerHTML = cart.map((item, index) => {
            total += item.price * item.quantity;
            return `
                <div class="flex gap-4 p-4 bg-gray-50 rounded-2xl group relative">
                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-white border border-gray-100">
                        <img src="assets/images/${item.image}" alt="${item.name}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-sm mb-1">${item.name}</h4>
                        <p class="text-xs text-gray-500 mb-2">₱${item.price.toLocaleString()}</p>
                        <div class="flex items-center gap-3">
                            <button onclick="changeQty(${index}, -1)" class="w-6 h-6 flex items-center justify-center bg-white border border-gray-200 rounded-lg hover:bg-black hover:text-white transition-all">-</button>
                            <span class="text-sm font-bold">${item.quantity}</span>
                            <button onclick="changeQty(${index}, 1)" class="w-6 h-6 flex items-center justify-center bg-white border border-gray-200 rounded-lg hover:bg-black hover:text-white transition-all">+</button>
                        </div>
                    </div>
                    <button onclick="removeFromCart(${index})" class="absolute top-2 right-2 text-gray-300 hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            `;
        }).join('');

        cartTotal.textContent = `₱${total.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        cartCount.textContent = cart.reduce((acc, item) => acc + item.quantity, 0);
        localStorage.setItem('yankicks_cart', JSON.stringify(cart));
    };

    // Add to Cart
    window.addToCart = (productId) => {
        // In a real app, we'd fetch product details from the API
        // For this demo, we'll find it in the allProducts array if it exists
        const product = typeof allProducts !== 'undefined' ? allProducts.find(p => p.id == productId) : null;
        
        if (product) {
            const existing = cart.find(item => item.id == productId);
            if (existing) {
                existing.quantity += 1;
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: parseFloat(product.price),
                    image: product.image,
                    quantity: 1
                });
            }
            updateCartUI();
            cartSidebar.classList.remove('translate-x-full');
        }
    };

    window.changeQty = (index, delta) => {
        cart[index].quantity += delta;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        updateCartUI();
    };

    window.removeFromCart = (index) => {
        cart.splice(index, 1);
        updateCartUI();
    };

    // Initial UI Update
    updateCartUI();
});

