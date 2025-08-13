<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>LuxAuto - LuxParts</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  @vite('resources/css/app.css')
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'primary-bg': '#e0f0ff',
            'accent-blue': '#007bff',
          },
          keyframes: {
            pulse: {
              '0%': { boxShadow: '0 4px 20px rgba(0, 123, 255, 0.4)' },
              '50%': { boxShadow: '0 4px 20px rgba(0, 123, 255, 0.8)' },
              '100%': { boxShadow: '0 4px 20px rgba(0, 123, 255, 0.4)' },
            }
          }
        }
      }
    }
  </script>
  <style>
    body {
      background-image: url('images/stretch-image5.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }

    /* Add this for the overlay */
    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Black with 50% opacity */
        z-index: 1;
    }

    /* Put your content above the overlay */
    body > * {
        position: relative;
        z-index: 2;
    }
    
    .nav-link-hover {
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .nav-link-hover::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: #007bff;
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: all 0.5s ease;
      z-index: 0;
    }

    .nav-link-hover:hover::before {
      width: 300px;
      height: 300px;
    }

    .nav-link-hover:hover {
      color: white !important;
      background-color: #007bff;
    }

    .nav-link-hover span {
      position: relative;
      z-index: 1;
    }
    
    .product-card {
      transition: all 0.3s ease;
    }
    
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,123,255,0.15);
    }
    
    .menu-icon {
      position: relative;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .menu-icon:hover {
      background-color: #007bff;
      color: white;
      transform: translateY(-2px);
    }
    
    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .success-animation {
      animation: pulse 0.6s ease-in-out;
    }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }
    
    .payment-method {
      transition: all 0.3s;
    }
    
    .payment-method:hover {
      border-color: #007bff;
      background-color: #f8f9fa;
    }
    
    .payment-method.selected {
      border-color: #007bff;
      background-color: rgba(0,123,255,0.1);
    }
    
    .offcanvas {
      position: fixed;
      top: 0;
      right: -100%;
      width: 450px;
      height: 100vh;
      background: white;
      transition: right 0.3s ease;
      z-index: 1000;
      box-shadow: -2px 0 10px rgba(0,0,0,0.1);
    }
    
    .offcanvas.show {
      right: 0;
    }
    
    .offcanvas-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 999;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    
    .offcanvas-backdrop.show {
      opacity: 1;
      visibility: visible;
    }
    
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1001;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    
    .modal.show {
      opacity: 1;
      visibility: visible;
    }
    
    .modal-content {
      background: white;
      border-radius: 8px;
      max-width: 800px;
      width: 90%;
      max-height: 90vh;
      overflow-y: auto;
    }
	
	.mobile-menu {
      display: none;
    }

    .mobile-menu.active {
      display: block;
    }

    @media (max-width: 768px) {
      .desktop-nav {
        display: none;
      }
    }

    @media (min-width: 769px) {
      .mobile-menu-button {
        display: none;
      }
    }
	
  </style>
</head>
<body class="bg-gray-100">

  <!-- Navigation -->
  <header class="p-3 bg-accent-blue">
    <nav class="bg-white shadow-lg p-3">
      <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center">
          <a class="text-accent-blue font-bold text-xl" href="brandnewcommerce.html">LuxParts</a>
          
          <!-- Mobile menu button -->
          <button class="mobile-menu-button md:hidden text-gray-500 hover:text-gray-700 focus:outline-none" onclick="toggleMobileMenu()">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>

          <!-- Desktop navigation -->
          <ul class="desktop-nav flex space-x-1">
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/"><span>Home</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/aboutus"><span>About Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block bg-accent-blue text-white" href="/shop"><span>Shop</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/contactus"><span>Contact Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/loginregister"><span>Login</span></a></li>
          </ul>
        </div>

        <!-- Mobile navigation -->
        <div class="mobile-menu mt-4">
          <ul class="flex flex-col space-y-2">
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/"><span>Home</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/aboutus"><span>About Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block bg-accent-blue text-white" href="/shop"><span>Shop</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/contactus"><span>Contact Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/loginregister"><span>Login</span></a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  
  <!-- Menu Icons -->
  <div class="flex items-center ml-3 space-x-2">

    <div class="absolute inset-0 bg-black opacity-60 z-0"></div>
    <!-- Shopping Cart -->
    <div class="menu-icon relative p-2 rounded-lg text-blue-600 hover:bg-blue-600 hover:text-white cursor-pointer" onclick="toggleOffcanvas('cartOffcanvas')">
      <i class="fas fa-shopping-cart text-lg"></i>
      <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs" id="cartBadge">0</span>
    </div>
    
    <!-- Account Settings -->
    <div class="menu-icon p-2 rounded-lg text-blue-600 hover:bg-blue-600 hover:text-white cursor-pointer" onclick="toggleOffcanvas('settingsOffcanvas')">
      <i class="fas fa-cog text-lg"></i>
    </div>
    
    <!-- Account Info -->
    <div class="menu-icon p-2 rounded-lg text-blue-600 hover:bg-blue-600 hover:text-white cursor-pointer" onclick="toggleOffcanvas('accountOffcanvas')">
      <i class="fas fa-user text-lg"></i>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex justify-center py-5">
    <div class="bg-white bg-opacity-90 p-5 rounded-[50px] w-[95%] shadow-lg">
      <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-blue-600 mb-3">Premium Auto Parts</h1>
        <p class="text-gray-600 text-lg">Discover high-quality spare parts for your vehicle</p>
      </div>
	  
	  <div class="mt-4 flex justify-center">
	  <input
		type="text"
		id="searchInput"
		placeholder="Search for products..."
		class="w-full max-w-lg px-4 py-2 border rounded-l-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
	  <button
		onclick="filterProducts()"
		class="bg-blue-600 text-white px-6 py-2 rounded-r-lg hover:bg-blue-700 transition">
		Search
	  </button>
	</div>
  <div>
    <div>
      <!-- Product Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="productGrid">
        <!-- Products will be loaded from database -->
        <div class="text-center py-10">
          <i class="fas fa-spinner fa-spin text-3xl text-blue-600"></i>
          <p class="text-gray-600 mt-3">Loading products...</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Offcanvas Backdrop -->
  <div class="offcanvas-backdrop" id="offcanvasBackdrop" onclick="closeAllOffcanvas()"></div>

  <!-- Shopping Cart Offcanvas -->
  <div class="offcanvas" id="cartOffcanvas">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 flex justify-between items-center">
      <h5 class="text-lg font-semibold"><i class="fas fa-shopping-cart mr-2"></i>Shopping Cart</h5>
      <button class="text-white hover:text-gray-200" onclick="closeOffcanvas('cartOffcanvas')">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="p-4 flex-1 overflow-y-auto">
      <div id="cartItems"></div>
      <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-5 mt-5 hidden" id="checkoutSummary">
        <h6 class="font-semibold mb-3">Order Summary</h6>
        <div class="flex justify-between mb-2">
          <span>Subtotal:</span>
          <span id="subtotal">$0.00</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Shipping:</span>
          <span id="shipping">$5.99</span>
        </div>
        <div class="flex justify-between mb-3 border-t pt-2">
          <strong>Total:</strong>
          <strong id="total">$0.00</strong>
        </div>
        <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors" onclick="showCheckout()">
          <i class="fas fa-credit-card mr-2"></i>Proceed to Checkout
        </button>
      </div>
    </div>
  </div>

  <!-- Settings Offcanvas -->
  <div class="offcanvas" id="settingsOffcanvas">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 flex justify-between items-center">
      <h5 class="text-lg font-semibold"><i class="fas fa-cog mr-2"></i>Settings</h5>
      <button class="text-white hover:text-gray-200" onclick="closeOffcanvas('settingsOffcanvas')">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="p-4">
      <div class="space-y-1">
        <a href="#" class="flex items-center justify-between p-3 hover:bg-gray-50 rounded">
          <div class="flex items-center">
            <i class="fas fa-bell mr-3 text-gray-600"></i>
            <span>Notifications</span>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" class="sr-only peer" checked>
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
          </label>
        </a>
        <a href="#" class="flex items-center justify-between p-3 hover:bg-gray-50 rounded">
          <div class="flex items-center">
            <i class="fas fa-moon mr-3 text-gray-600"></i>
            <span>Dark Mode</span>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
          </label>
        </a>
        <a href="#" class="flex items-center justify-between p-3 hover:bg-gray-50 rounded">
          <div class="flex items-center">
            <i class="fas fa-language mr-3 text-gray-600"></i>
            <span>Language</span>
          </div>
          <span class="bg-gray-500 text-white px-2 py-1 rounded text-sm">English</span>
        </a>
        <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded">
          <i class="fas fa-shield-alt mr-3 text-gray-600"></i>
          <span>Privacy & Security</span>
        </a>
        <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded">
          <i class="fas fa-download mr-3 text-gray-600"></i>
          <span>App Updates</span>
        </a>
        <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded">
          <i class="fas fa-question-circle mr-3 text-gray-600"></i>
          <span>Help & Support</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Account Offcanvas -->
  <div class="offcanvas" id="accountOffcanvas">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 flex justify-between items-center">
      <h5 class="text-lg font-semibold"><i class="fas fa-user mr-2"></i>My Account</h5>
      <button class="text-white hover:text-gray-200" onclick="closeOffcanvas('accountOffcanvas')">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="p-4">
      <div class="bg-gradient-to-r from-white to-gray-50 rounded-lg p-4 mb-4 shadow-sm" id="userInfo">
        <div class="text-center">
          <div class="bg-blue-600 rounded-full w-20 h-20 flex items-center justify-center mx-auto">
            <i class="fas fa-user text-white text-2xl"></i>
          </div>
          <h5 class="mt-3 mb-1 font-semibold" id="userName">Loading...</h5>
          <p class="text-gray-600" id="userType">Loading...</p>
          <p class="text-gray-500 text-sm" id="userEmail"></p>
          <p class="text-gray-500 text-sm" id="userPhone"></p>
        </div>
      </div>
      
      <div class="space-y-1">
        <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded" onclick="editProfile()">
          <i class="fas fa-edit mr-3 text-gray-600"></i>
          <span>Edit Profile</span>
        </a>
        <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded">
          <i class="fas fa-box mr-3 text-gray-600"></i>
          <span>My Orders</span>
        </a>
        <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded">
          <i class="fas fa-heart mr-3 text-gray-600"></i>
          <span>Wishlist</span>
        </a>
        <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded">
          <i class="fas fa-map-marker-alt mr-3 text-gray-600"></i>
          <span>Addresses</span>
        </a>
        <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded">
          <i class="fas fa-credit-card mr-3 text-gray-600"></i>
          <span>Payment Methods</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="block">
          @csrf
          <button type="submit" class="w-full text-left flex items-center p-3 hover:bg-gray-50 rounded text-red-600">
            <i class="fas fa-sign-out-alt mr-3"></i>
            <span>Logout</span>
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Checkout Offcanvas -->
  <div class="offcanvas w-[500px]" id="checkoutOffcanvas">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 flex justify-between items-center">
      <h5 class="text-lg font-semibold"><i class="fas fa-credit-card mr-2"></i>Checkout</h5>
      <button class="text-white hover:text-gray-200" onclick="closeOffcanvas('checkoutOffcanvas')">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="p-4 overflow-y-auto">
      <form id="checkoutForm">
        <h6 class="font-semibold mb-3">Shipping Information</h6>
        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
          <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="fullName" required>
        </div>
        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
          <input type="email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="email" required>
        </div>
        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Address</label>
          <textarea class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent h-24" id="address" required></textarea>
        </div>
        
        <h6 class="font-semibold mb-3">Payment Method</h6>
        <div class="flex flex-wrap gap-2 mb-3">
          <div class="payment-method selected border-2 border-blue-600 bg-blue-50 rounded-lg p-3 cursor-pointer" data-method="card">
            <i class="fas fa-credit-card mr-2"></i>Card
          </div>
          <div class="payment-method border-2 border-gray-300 bg-white rounded-lg p-3 cursor-pointer" data-method="paypal">
            <i class="fab fa-paypal mr-2"></i>PayPal
          </div>
          <div class="payment-method border-2 border-gray-300 bg-white rounded-lg p-3 cursor-pointer" data-method="apple">
            <i class="fab fa-apple-pay mr-2"></i>Apple Pay
          </div>
        </div>
        
        <div id="cardDetails" class="mb-3">
          <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Card Information</label>
            <div id="card-element" class="w-full p-3 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent">
              <!-- Stripe Elements will create form elements here -->
            </div>
            <div id="card-errors" role="alert" class="text-red-600 text-sm mt-1"></div>
          </div>
        </div>
        
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-5">
          <div class="flex justify-between mb-2">
            <span>Items:</span>
            <span id="checkoutSubtotal">$0.00</span>
          </div>
          <div class="flex justify-between mb-2">
            <span>Shipping:</span>
            <span>$5.99</span>
          </div>
          <div class="flex justify-between mb-3 border-t pt-2">
            <strong>Total:</strong>
            <strong id="checkoutTotal">$0.00</strong>
          </div>
          <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
            <i class="fas fa-lock mr-2"></i>Complete Order
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Product Info Modal -->
  <div class="modal" id="productModal">
    <div class="modal-content">
      <div class="border-b p-4 flex justify-between items-center">
        <h5 class="text-xl font-semibold" id="modalTitle">Product Information</h5>
        <button class="text-gray-500 hover:text-gray-700" onclick="closeModal('productModal')">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="p-4" id="modalBody">
        <!-- Product details will be inserted here -->
      </div>
      <div class="border-t p-4 flex justify-end space-x-3">
        <button class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600" onclick="closeModal('productModal')">Close</button>
        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" id="modalAddToCart">Add to Cart</button>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="text-center text-white py-4 mt-10 bg-gray-800">
    &copy; 2024 LuxParts - All rights reserved.
  </footer>

  <script>
    // Global variables
    let cart = [];
    let currentProduct = null;
    let products = [];
    let user = null;
    let stripeClientSecret = null;

    // Initialize Stripe
    const stripe = Stripe('{{ config("payment.stripe.public_key") }}');
    const elements = stripe.elements();

    const cardElement = elements.create('card', {
      style: {
        base: {
          fontSize: '16px',
          color: '#424770',
          '::placeholder': {
            color: '#aab7c4',
          },
        },
      },
    });

    // Initialize the application
    async function initApp() {
      try {
        await Promise.all([
          loadProducts(),
          loadUserInfo(),
          loadCart()
        ]);
        updateCartBadge();
        updateCartDisplay();
      } catch (error) {
        console.error('Failed to initialize app:', error);
        showError('Failed to load application data');
      }
    }

    // Load products from database
    async function loadProducts() {
      try {
        const response = await fetch('/api/products');
        if (!response.ok) throw new Error('Failed to fetch products');
        
        const parts = await response.json();
        
        // Transform parts data to match expected format
        products = parts.map(part => ({
          id: part.id,
          name: part.partName,
          price: parseFloat(part.price),
          image: `https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=300&h=220&fit=crop&auto=format&q=80&seed=${part.id}`,
          description: part.description,
          features: ["High Quality", "OEM Compatible", "Warranty Included", "Fast Shipping"],
          category: part.brand,
          partNumber: part.partNumber,
          model: part.model,
          quantityInStock: part.quantityInStock
        }));
        
        renderProducts();
      } catch (error) {
        console.error('Failed to load products:', error);
        showFallbackProducts();
      }
    }

    // Load user information from API
    async function loadUserInfo() {
      try {
        const response = await fetch('/api/user', {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
          }
        });
        
        if (!response.ok) throw new Error('Failed to fetch user info');
        
        user = await response.json();
        updateUserDisplay();
      } catch (error) {
        console.error('Failed to load user info:', error);
        user = {
          name: "Guest User",
          email: "guest@example.com",
          type: "Customer"
        };
        updateUserDisplay();
      }
    }

    // Load cart from database
    async function loadCart() {
      try {
        const response = await fetch('/api/cart', {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
          }
        });
        
        if (!response.ok) throw new Error('Failed to fetch cart');
        
        const cartItems = await response.json();
        cart = cartItems.map(item => ({
          id: item.part.id,
          name: item.part.partName,
          price: parseFloat(item.part.price),
          image: `https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=300&h=220&fit=crop&auto=format&q=80&seed=${item.part.id}`,
          quantity: item.quantity,
          category: item.part.brand
        }));
        
      } catch (error) {
        console.error('Failed to load cart:', error);
        cart = [];
      }
    }

    // Add product to cart
    async function addToCart(productId) {
      try {
        const response = await fetch('/api/cart', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
          },
          body: JSON.stringify({
            part_id: productId,
            quantity: 1
          })
        });

        if (!response.ok) throw new Error('Failed to add to cart');
        
        await loadCart();
        updateCartBadge();
        updateCartDisplay();
        
        // Show success animation
        const button = event.target.closest('button');
        button.classList.add('success-animation');
        setTimeout(() => button.classList.remove('success-animation'), 600);
        
      } catch (error) {
        console.error('Failed to add to cart:', error);
        alert('Failed to add item to cart');
      }
    }

    // Update quantity
    async function updateQuantity(productId, change) {
      const item = cart.find(item => item.id === productId);
      if (!item) return;
      
      const newQuantity = item.quantity + change;
      
      if (newQuantity <= 0) {
        await removeFromCart(productId);
        return;
      }
      
      try {
        const cartItem = await findCartItem(productId);
        if (!cartItem) return;
        
        const response = await fetch(`/api/cart/${cartItem.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
          },
          body: JSON.stringify({
            quantity: newQuantity
          })
        });

        if (!response.ok) throw new Error('Failed to update quantity');
        
        await loadCart();
        updateCartBadge();
        updateCartDisplay();
        
      } catch (error) {
        console.error('Failed to update quantity:', error);
        alert('Failed to update item quantity');
      }
    }

    // Remove from cart
    async function removeFromCart(productId) {
      try {
        const cartItem = await findCartItem(productId);
        if (!cartItem) return;
        
        const response = await fetch(`/api/cart/${cartItem.id}`, {
          method: 'DELETE',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
          }
        });

        if (!response.ok) throw new Error('Failed to remove from cart');
        
        await loadCart();
        updateCartBadge();
        updateCartDisplay();
        
      } catch (error) {
        console.error('Failed to remove from cart:', error);
        alert('Failed to remove item from cart');
      }
    }

    // Helper function to find cart item
    async function findCartItem(productId) {
      try {
        const response = await fetch('/api/cart');
        const cartItems = await response.json();
        return cartItems.find(item => item.part.id === productId);
      } catch (error) {
        console.error('Failed to find cart item:', error);
        return null;
      }
    }

    // Update user display
    function updateUserDisplay() {
      if (user) {
        document.getElementById('userName').textContent = user.name;
        document.getElementById('userType').textContent = user.type;
      }
    }

    // Render products
    function renderProducts() {
      const grid = document.getElementById('productGrid');
      if (!products.length) {
        grid.innerHTML = `
          <div class="col-span-full text-center py-10">
            <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 text-lg">No products available</p>
          </div>
        `;
        return;
      }

      grid.innerHTML = products.map(product => `
        <div class="product-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
          <img src="${product.image}" class="w-full h-48 object-cover" alt="${product.name}">
          <div class="p-4">
            <h5 class="font-semibold text-lg mb-2">${product.name}</h5>
            <p class="text-gray-600 text-sm mb-3">${product.description}</p>
            <div class="flex justify-between items-center mb-3">
              <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">${product.category}</span>
              <span class="text-green-600 font-bold text-lg">$${product.price}</span>
            </div>
            <div class="flex gap-2">
              <button 
                class="flex-1 bg-blue-600 text-white py-2 px-3 rounded hover:bg-blue-700 transition-colors text-sm"
                onclick="showProductInfo(${product.id})">
                <i class="fas fa-info-circle mr-1"></i>Info
              </button>
              <button 
                class="flex-1 bg-green-600 text-white py-2 px-3 rounded hover:bg-green-700 transition-colors text-sm"
                onclick="addToCart(${product.id})"
                ${product.quantityInStock <= 0 ? 'disabled' : ''}>
                <i class="fas fa-cart-plus mr-1"></i>Add
              </button>
            </div>
            ${product.quantityInStock <= 0 ? '<p class="text-red-500 text-xs mt-2">Out of Stock</p>' : ''}
          </div>
        </div>
      `).join('');
    }

    // Show product information
    function showProductInfo(productId) {
      const product = products.find(p => p.id === productId);
      currentProduct = product;
      
      document.getElementById('modalTitle').textContent = product.name;
      document.getElementById('modalBody').innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <img src="${product.image}" class="w-full rounded-lg" alt="${product.name}">
          </div>
          <div>
            <h4 class="text-2xl font-bold text-green-600 mb-3">$${product.price}</h4>
            <p class="mb-4">${product.description}</p>
            <div class="mb-4">
              <h6 class="font-semibold mb-2">Details:</h6>
              <ul class="space-y-1">
                <li><strong>Part Number:</strong> ${product.partNumber}</li>
                <li><strong>Brand:</strong> ${product.category}</li>
                <li><strong>Model:</strong> ${product.model}</li>
                <li><strong>Stock:</strong> ${product.quantityInStock} units</li>
              </ul>
            </div>
            <h6 class="font-semibold mb-2">Key Features:</h6>
            <ul class="space-y-1">
              ${product.features.map(feature => `<li><i class="fas fa-check text-green-500 mr-2"></i>${feature}</li>`).join('')}
            </ul>
          </div>
        </div>
      `;
      
      showModal('productModal');
    }

    // Update cart badge
    function updateCartBadge() {
      const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
      document.getElementById('cartBadge').textContent = totalItems;
    }

    // Update cart display
    function updateCartDisplay() {
      const cartItems = document.getElementById('cartItems');
      const checkoutSummary = document.getElementById('checkoutSummary');
      
      if (cart.length === 0) {
        cartItems.innerHTML = `
          <div class="text-center py-8">
            <i class="fas fa-shopping-cart text-4xl text-gray-400 mb-3"></i>
            <p class="text-gray-600">Your cart is empty</p>
          </div>
        `;
        checkoutSummary.classList.add('hidden');
        return;
      }
      
      cartItems.innerHTML = cart.map(item => `
        <div class="border-b pb-4 mb-4">
          <div class="flex items-center gap-3">
            <img src="${item.image}" class="w-16 h-16 object-cover rounded" alt="${item.name}">
            <div class="flex-1">
              <h6 class="font-semibold">${item.name}</h6>
              <p class="text-gray-600 text-sm">$${item.price.toFixed(2)} each</p>
            </div>
            <div class="flex items-center gap-2">
              <button class="bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded flex items-center justify-center" onclick="updateQuantity(${item.id}, -1)">-</button>
              <span class="w-8 text-center">${item.quantity}</span>
              <button class="bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded flex items-center justify-center" onclick="updateQuantity(${item.id}, 1)">+</button>
              <button class="text-red-500 hover:text-red-700 ml-2" onclick="removeFromCart(${item.id})">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
        </div>
      `).join('');
      
      updateCartSummary();
      checkoutSummary.classList.remove('hidden');
    }

    // Update cart summary
    function updateCartSummary() {
      const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
      const shipping = 5.99;
      const total = subtotal + shipping;
      
      document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
      document.getElementById('total').textContent = `$${total.toFixed(2)}`;
      document.getElementById('checkoutSubtotal').textContent = `$${subtotal.toFixed(2)}`;
      document.getElementById('checkoutTotal').textContent = `$${total.toFixed(2)}`;
    }

    // Show checkout
    async function showCheckout() {
      if (cart.length === 0) {
        alert('Your cart is empty');
        return;
      }

      closeOffcanvas('cartOffcanvas');
      toggleOffcanvas('checkoutOffcanvas');
      
      // Pre-populate user information
      if (user) {
        document.getElementById('fullName').value = user.name || '';
        document.getElementById('email').value = user.email || '';
      }
    }

    // Create payment intent
    async function createPaymentIntent() {
      try {
        const shippingAddress = {
          name: document.getElementById('fullName').value,
          email: document.getElementById('email').value,
          address: document.getElementById('address').value
        };

        const response = await fetch('/api/payment/intent', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
          },
          body: JSON.stringify({ shipping_address: shippingAddress })
        });

        if (!response.ok) throw new Error('Failed to create payment intent');
        
        const data = await response.json();
        stripeClientSecret = data.client_secret;
        return data;
        
      } catch (error) {
        console.error('Failed to create payment intent:', error);
        throw error;
      }
    }

    // Process payment (simplified for demo)
    async function processPayment() {
      try {
        const paymentData = await createPaymentIntent();
        
        // In a real implementation, you would use Stripe Elements here
        // For demo purposes, we'll simulate a successful payment
        const shippingAddress = {
          name: document.getElementById('fullName').value,
          email: document.getElementById('email').value,
          address: document.getElementById('address').value
        };

        const response = await fetch('/api/payment/confirm', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
          },
          body: JSON.stringify({
            payment_intent_id: 'demo_payment_' + Date.now(),
            shipping_address: shippingAddress
          })
        });

        if (!response.ok) throw new Error('Payment failed');
        
        const result = await response.json();
        
        // Clear cart and show success
        cart = [];
        updateCartBadge();
        updateCartDisplay();
        closeOffcanvas('checkoutOffcanvas');
        
        alert('Order placed successfully! Thank you for your purchase.');
        
        return result;
        
      } catch (error) {
        console.error('Payment failed:', error);
        alert('Payment failed. Please try again.');
        throw error;
      }
    }

    // Checkout form submission
    document.addEventListener('DOMContentLoaded', function() {
      const checkoutForm = document.getElementById('checkoutForm');
      if (checkoutForm) {
        checkoutForm.addEventListener('submit', async function(e) {
          e.preventDefault();
          
          const submitBtn = e.target.querySelector('button[type="submit"]');
          const originalText = submitBtn.innerHTML;
          
          submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
          submitBtn.disabled = true;
          
          try {
            await processPayment();
          } catch (error) {
            console.error('Checkout failed:', error);
          } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
          }
        });
      }
    });

    // Utility functions
    function toggleOffcanvas(id) {
      const offcanvas = document.getElementById(id);
      const backdrop = document.getElementById('offcanvasBackdrop');
      
      offcanvas.classList.toggle('show');
      backdrop.classList.toggle('show');
    }

    function closeOffcanvas(id) {
      const offcanvas = document.getElementById(id);
      const backdrop = document.getElementById('offcanvasBackdrop');
      
      offcanvas.classList.remove('show');
      backdrop.classList.remove('show');
    }

    function closeAllOffcanvas() {
      document.querySelectorAll('.offcanvas').forEach(offcanvas => {
        offcanvas.classList.remove('show');
      });
      document.getElementById('offcanvasBackdrop').classList.remove('show');
    }

    function showModal(id) {
      document.getElementById(id).classList.add('show');
    }

    function closeModal(id) {
      document.getElementById(id).classList.remove('show');
    }

    function toggleMobileMenu() {
      const mobileMenu = document.querySelector('.mobile-menu');
      mobileMenu.classList.toggle('active');
    }

    function showError(message) {
      alert(message); // In production, use a proper toast/notification system
    }

    function showFallbackProducts() {
      // Fallback products for demo
      products = [
        {
          id: 1,
          name: "Brake Pad Set",
          price: 45.99,
          image: "https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=300&h=220&fit=crop&auto=format&q=80",
          description: "High-performance brake pads for optimal stopping power",
          features: ["High Quality", "OEM Compatible", "Warranty Included", "Fast Shipping"],
          category: "Bosch",
          partNumber: "BP001",
          model: "Universal",
          quantityInStock: 15
        },
        {
          id: 2,
          name: "Air Filter",
          price: 19.99,
          image: "https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=300&h=220&fit=crop&auto=format&q=80",
          description: "Premium air filter for enhanced engine performance",
          features: ["High Quality", "OEM Compatible", "Warranty Included", "Fast Shipping"],
          category: "K&N",
          partNumber: "AF002",
          model: "Universal",
          quantityInStock: 23
        }
      ];
      renderProducts();
    }

    function filterProducts() {
      const searchTerm = document.getElementById('searchInput').value.toLowerCase();
      
      if (!searchTerm) {
        renderProducts();
        return;
      }
      
      const filteredProducts = products.filter(product => 
        product.name.toLowerCase().includes(searchTerm) ||
        product.description.toLowerCase().includes(searchTerm) ||
        product.category.toLowerCase().includes(searchTerm) ||
        product.partNumber.toLowerCase().includes(searchTerm)
      );
      
      const grid = document.getElementById('productGrid');
      if (filteredProducts.length === 0) {
        grid.innerHTML = `
          <div class="col-span-full text-center py-10">
            <i class="fas fa-search text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 text-lg">No products found matching "${searchTerm}"</p>
            <button onclick="document.getElementById('searchInput').value=''; filterProducts();" 
                    class="mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
              Clear Search
            </button>
          </div>
        `;
        return;
      }
      
      grid.innerHTML = filteredProducts.map(product => `
        <div class="product-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
          <img src="${product.image}" class="w-full h-48 object-cover" alt="${product.name}">
          <div class="p-4">
            <h5 class="font-semibold text-lg mb-2">${product.name}</h5>
            <p class="text-gray-600 text-sm mb-3">${product.description}</p>
            <div class="flex justify-between items-center mb-3">
              <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">${product.category}</span>
              <span class="text-green-600 font-bold text-lg">${product.price}</span>
            </div>
            <div class="flex gap-2">
              <button 
                class="flex-1 bg-blue-600 text-white py-2 px-3 rounded hover:bg-blue-700 transition-colors text-sm"
                onclick="showProductInfo(${product.id})">
                <i class="fas fa-info-circle mr-1"></i>Info
              </button>
              <button 
                class="flex-1 bg-green-600 text-white py-2 px-3 rounded hover:bg-green-700 transition-colors text-sm"
                onclick="addToCart(${product.id})"
                ${product.quantityInStock <= 0 ? 'disabled' : ''}>
                <i class="fas fa-cart-plus mr-1"></i>Add
              </button>
            </div>
            ${product.quantityInStock <= 0 ? '<p class="text-red-500 text-xs mt-2">Out of Stock</p>' : ''}
          </div>
        </div>
      `).join('');
    }

    // Payment method selection
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('click', function() {
          document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
          this.classList.add('selected');
          
          const cardDetails = document.getElementById('cardDetails');
          if (cardDetails) {
            cardDetails.style.display = this.dataset.method === 'card' ? 'block' : 'none';
          }
        });
      });

      // Modal add to cart button
      const modalAddToCart = document.getElementById('modalAddToCart');
      if (modalAddToCart) {
        modalAddToCart.addEventListener('click', function() {
          if (currentProduct) {
            addToCart(currentProduct.id);
            closeModal('productModal');
          }
        });
      }

      // Search on Enter key
      const searchInput = document.getElementById('searchInput');
      if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            filterProducts();
          }
        });
      }

      // Initialize the app
      initApp();
    });

    // Edit profile functionality
    async function editProfile() {
      const name = prompt('Enter your name:', user.name);
      const email = prompt('Enter your email:', user.email);
      const phone = prompt('Enter your phone:', user.phone || '');
      
      if (name && email) {
        try {
          const response = await fetch('/api/user', {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
              customerName: name,
              email: email,
              contactNumber: phone
            })
          });

          if (!response.ok) throw new Error('Failed to update profile');
          
          const result = await response.json();
          
          // Update local user object
          user.name = name;
          user.email = email;
          user.phone = phone;
          
          updateUserDisplay();
          alert('Profile updated successfully!');
          
        } catch (error) {
          console.error('Failed to update profile:', error);
          alert('Failed to update profile. Please try again.');
        }
      }
    }

    //Mount Card element
    document.addEventListener('DOMContentLoaded', function() {
      if (document.getElementById('card-element')) {
        cardElement.mount('#card-element');
        
        // Handle real-time validation errors from the card Element
        cardElement.on('change', function(event) {
          const displayError = document.getElementById('card-errors');
          if (event.error) {
            displayError.textContent = event.error.message;
          } else {
            displayError.textContent = '';
          }
        });
      }
    });

    // Updated process payment function with real Stripe integration
    async function processPaymentWithStripe() {
      try {
        const paymentData = await createPaymentIntent();
        
        const shippingAddress = {
          name: document.getElementById('fullName').value,
          email: document.getElementById('email').value,
          address: document.getElementById('address').value
        };

        // Confirm payment with Stripe
        const {error, paymentIntent} = await stripe.confirmCardPayment(paymentData.client_secret, {
          payment_method: {
            card: cardElement,
            billing_details: {
              name: shippingAddress.name,
              email: shippingAddress.email,
            }
          }
        });

        if (error) {
          throw new Error(error.message);
        }

        if (paymentIntent.status === 'succeeded') {
          // Confirm with backend
          const response = await fetch('/api/payment/confirm', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
              payment_intent_id: paymentIntent.id,
              shipping_address: shippingAddress
            })
          });

          if (!response.ok) throw new Error('Failed to confirm order');
          
          const result = await response.json();
          
          // Clear cart and show success
          cart = [];
          updateCartBadge();
          updateCartDisplay();
          closeOffcanvas('checkoutOffcanvas');
          
          alert('Order placed successfully! Thank you for your purchase.');
          
          return result;
        }
        
      } catch (error) {
        console.error('Payment failed:', error);
        alert('Payment failed: ' + error.message);
        throw error;
      }
    }
  </script>

</body>
</html>
