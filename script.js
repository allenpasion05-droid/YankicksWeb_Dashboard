// Products array (fetched from PHP)
let products = [];

// Cart State
let cart = [];

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    initializeCart();
    initializeEventListeners();
    
    // Load shop page content if on shop page
    if (document.getElementById('productsGrid')) {
        fetchProducts();
    }
});

// Fetch products from PHP API
function fetchProducts() {
    fetch('api/products.php')
        .then(res => res.json())
        .then(data => {
            products = data;
            displayProducts(products);
        })
        .catch(err => console.error('Error fetching products:', err));
}

// Initialize Cart from localStorage
function initializeCart() {
    const savedCart = localStorage.getItem('yankicks_cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartUI();
    }
}

// Initialize Event Listeners
function initializeEventListeners() {
    const cartBtn = document.getElementById('cartBtn');
    const closeCart = document.getElementById('closeCart');
    const cartSidebar = document.getElementById('cartSidebar');
    const contactForm = document.getElementById('contactForm');

    if (cartBtn) {
        cartBtn.addEventListener('click', () => {
            cartSidebar.classList.toggle('active');
        });
    }

    if (closeCart) {
        closeCart.addEventListener('click', () => {
            cartSidebar.classList.remove('active');
        });
    }

    // Close cart when clicking outside
    document.addEventListener('click', (e) => {
        if (cartSidebar && !cartSidebar.contains(e.target) && e.target !== cartBtn && !cartBtn?.contains(e.target)) {
            cartSidebar.classList.remove('active');
        }
    });

    if (contactForm) {
        contactForm.addEventListener('submit', handleContactForm);
    }

    // Filter functionality
    const categoryFilter = document.getElementById('categoryFilter');
    const priceFilter = document.getElementById('priceFilter');

    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterProducts);
    }

    if (priceFilter) {
        priceFilter.addEventListener('change', sortProducts);
    }
}

// Display Products
function displayProducts(productsToDisplay) {
    const grid = document.getElementById('productsGrid');
    if (!grid) return;

    grid.innerHTML = productsToDisplay.map(product => `
        <div class="product-card">
            <img src="${product.image}" alt="${product.name}" class="product-image">
            <div class="product-info">
                <div class="product-category">${product.category}</div>
                <h3 class="product-name">${product.name}</h3>
                <div class="product-price">₱${parseFloat(product.price).toFixed(2)}</div>
                <div class="product-rating">
                    ${'★'.repeat(product.rating)}${'☆'.repeat(5 - product.rating)} (${product.rating}.0)
                </div>
                <button class="add-to-cart-btn" onclick="addToCart(${product.id})">
                    Add to Cart
                </button>
            </div>
        </div>
    `).join('');
}

// Add to Cart
function addToCart(productId) {
    const product = products.find(p => parseInt(p.id) === parseInt(productId));
    const cartItem = cart.find(item => parseInt(item.id) === parseInt(productId));

    if (cartItem) {
        cartItem.quantity++;
    } else {
        cart.push({
            ...product,
            quantity: 1
        });
    }

    saveCart();
    updateCartUI();
    
    // Show feedback
    const cartBtn = document.getElementById('cartBtn');
    cartBtn.style.transform = 'scale(1.2)';
    setTimeout(() => {
        cartBtn.style.transform = 'scale(1)';
    }, 200);
}

// Update Cart UI
function updateCartUI() {
    const cartCount = document.getElementById('cartCount');
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');

    if (!cartCount || !cartItems) return;

    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;

    cartItems.innerHTML = cart.map(item => `
        <div class="cart-item">
            <div class="cart-item-info">
                <h3>${item.name}</h3>
                <p>₱${parseFloat(item.price).toFixed(2)} × ${item.quantity}</p>
            </div>
            <div class="cart-item-actions">
                <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">−</button>
                <span>${item.quantity}</span>
                <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                <button class="remove-btn" onclick="removeFromCart(${item.id})">✕</button>
            </div>
        </div>
    `).join('');

    const total = cart.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
    if (cartTotal) {
        cartTotal.textContent = '₱' + total.toFixed(2);
    }
}

// Update Quantity
function updateQuantity(productId, change) {
    const item = cart.find(i => parseInt(i.id) === parseInt(productId));
    if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
            removeFromCart(productId);
        } else {
            saveCart();
            updateCartUI();
        }
    }
}

// Remove from Cart
function removeFromCart(productId) {
    cart = cart.filter(item => parseInt(item.id) !== parseInt(productId));
    saveCart();
    updateCartUI();
}

// Save Cart to LocalStorage
function saveCart() {
    localStorage.setItem('yankicks_cart', JSON.stringify(cart));
}

// Filter Products
function filterProducts() {
    const category = document.getElementById('categoryFilter').value;
    const filtered = category === 'all' 
        ? products 
        : products.filter(p => p.category === category);
    displayProducts(filtered);
}

// Sort Products
function sortProducts() {
    const sortValue = document.getElementById('priceFilter').value;
    let sorted = [...products];

    if (sortValue === 'low-high') {
        sorted.sort((a, b) => parseFloat(a.price) - parseFloat(b.price));
    } else if (sortValue === 'high-low') {
        sorted.sort((a, b) => parseFloat(b.price) - parseFloat(a.price));
    }

    displayProducts(sorted);
}

// Handle Contact Form
function handleContactForm(e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value;

    console.log('Form submitted:', { name, email, subject, message });
    
    alert('Thank you for your message! We will get back to you soon.');
    e.target.reset();
}
