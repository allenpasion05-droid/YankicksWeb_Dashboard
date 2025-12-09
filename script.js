// Currency conversion: USD to PHP (approximate rate: 1 USD = 56 PHP)
const USD_TO_PHP = 56;

// Product Database
const products = [
    {
        id: 1,
        name: 'AeroSpeed Pro',
        category: 'running',
        price: 149.99 * USD_TO_PHP,
        image: '/assets/images/aerospeedpro_shop.jpg',
        rating: 5
    },
    {
        id: 2,
        name: 'CloudRun Elite',
        category: 'running',
        price: 159.99 * USD_TO_PHP,
        image: '/assets/images/cloudrunelite_shop.jpg',
        rating: 5
    },
    {
        id: 3,
        name: 'SprintForce',
        category: 'running',
        price: 139.99 * USD_TO_PHP,
        image: '/assets/images/sprintforce_shop.jpg',
        rating: 4
    },
    {
        id: 4,
        name: 'CourtKing Pro',
        category: 'basketball',
        price: 189.99 * USD_TO_PHP,
        image: '/assets/images/courtkingpro_shop.jpg',
        rating: 5
    },
    {
        id: 5,
        name: 'SlamDunk Ultra',
        category: 'basketball',
        price: 179.99 * USD_TO_PHP,
        image: '/assets/images/slamdunkultra_shop.jpg',
        rating: 5
    },
    {
        id: 6,
        name: 'StreetBall Classic',
        category: 'basketball',
        price: 169.99 * USD_TO_PHP,
        image: '/assets/images/streetballclassic_shop.jpg',
        rating: 4
    },
    {
        id: 7,
        name: 'UrbanStyle Plus',
        category: 'lifestyle',
        price: 119.99 * USD_TO_PHP,
        image: '/assets/images/ubanstyle_shop.jpg',
        rating: 4
    },
    {
        id: 8,
        name: 'CityWalk Premium',
        category: 'lifestyle',
        price: 129.99 * USD_TO_PHP,
        image: '/assets/images/citywalkpremium_shop.jpg',
        rating: 5
    },
    {
        id: 9,
        name: 'StreetStyle Signature',
        category: 'lifestyle',
        price: 139.99 * USD_TO_PHP,
        image: '/assets/images/streetstylesignature_shop.jpg',
        rating: 4
    },
    {
        id: 10,
        name: 'TurboRun Max',
        category: 'running',
        price: 174.99 * USD_TO_PHP,
        image: '/assets/images/running_shoes.jpeg',
        rating: 5
    },
    {
        id: 11,
        name: 'Velocity Elite',
        category: 'running',
        price: 164.99 * USD_TO_PHP,
        image: '/assets/images/running_shoes.jpeg',
        rating: 5
    },
    {
        id: 12,
        name: 'HoopsMaster Pro',
        category: 'basketball',
        price: 199.99 * USD_TO_PHP,
        image: '/assets/images/basketball_shoes.jpg',
        rating: 5
    },
    {
        id: 13,
        name: 'JumpForce Supreme',
        category: 'basketball',
        price: 194.99 * USD_TO_PHP,
        image: '/assets/images/basketball_shoes.jpg',
        rating: 4
    },
    {
        id: 14,
        name: 'CasualComfort Pro',
        category: 'lifestyle',
        price: 144.99 * USD_TO_PHP,
        image: '/assets/images/lifestyle_shoes.jpg',
        rating: 5
    },
    {
        id: 15,
        name: 'MetroWalk Classic',
        category: 'lifestyle',
        price: 134.99 * USD_TO_PHP,
        image: '/assets/images/lifestyle_shoes.jpg',
        rating: 4
    },
    {
        id: 16,
        name: 'TrailBlazer X',
        category: 'running',
        price: 184.99 * USD_TO_PHP,
        image: '/assets/images/running_shoes.jpeg',
        rating: 5
    },
    {
        id: 17,
        name: 'ArenaPro Champion',
        category: 'basketball',
        price: 209.99 * USD_TO_PHP,
        image: '/assets/images/basketball_shoes.jpg',
        rating: 5
    },
    {
        id: 18,
        name: 'UrbanFlex Premium',
        category: 'lifestyle',
        price: 154.99 * USD_TO_PHP,
        image: '/assets/images/lifestyle_shoes.jpg',
        rating: 5
    }
];

// Cart State
let cart = [];

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    initializeCart();
    initializeEventListeners();
    
    // Load shop page content if on shop page
    if (document.getElementById('productsGrid')) {
        displayProducts(products);
    }
});

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
                <div class="product-price">₱${product.price.toFixed(2)}</div>
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
    const product = products.find(p => p.id === productId);
    const cartItem = cart.find(item => item.id === productId);

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
                <p>₱${item.price.toFixed(2)} × ${item.quantity}</p>
            </div>
            <div class="cart-item-actions">
                <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">−</button>
                <span>${item.quantity}</span>
                <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                <button class="remove-btn" onclick="removeFromCart(${item.id})">✕</button>
            </div>
        </div>
    `).join('');

    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    if (cartTotal) {
        cartTotal.textContent = '₱' + total.toFixed(2);
    }
}

// Update Quantity
function updateQuantity(productId, change) {
    const item = cart.find(i => i.id === productId);
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
    cart = cart.filter(item => item.id !== productId);
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
        sorted.sort((a, b) => a.price - b.price);
    } else if (sortValue === 'high-low') {
        sorted.sort((a, b) => b.price - a.price);
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