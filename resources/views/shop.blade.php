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

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

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

    #card-element {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: white;
    }

    .StripeElement {
      box-sizing: border-box;
      height: 40px;
      padding: 10px 12px;
      border: 1px solid transparent;
      border-radius: 4px;
      background-color: white;
      box-shadow: 0 1px 3px 0 #e6ebf1;
      transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
      box-shadow: 0 1px 3px 0 #cfd7df;
    }
  </style>
</head>
<body class="bg-gray-100">

  <!-- Navigation -->
  <header class="p-3 bg-accent-blue">
    <nav class="bg-white shadow-lg p-3">
      <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center">
          <a class="text-accent-blue font-bold text-xl" href="/">LuxParts</a>
          
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
  <div class="flex items-center ml-3 mr-3 space-x-2 bg-black opacity-70">
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
	  
	  <div class="mt-4 flex justify-center mb-8">
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

      <!-- Product Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="productGrid">
        <!-- Products will be loaded from database -->
        <div class="col-span-full text-center py-10">
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
          <p class="text-gray-600 text-sm" id="userType">Loading...</p>
          <p class="text-gray-500 text-sm" id="userEmail">Loading...</p>
          <p class="text-gray-500 text-sm" id="userPhone">Loading...</p>
        </div>
      </div>
      
      <div class="space-y-1">
        <button class="w-full text-left flex items-center p-3 hover:bg-gray-50 rounded" onclick="editProfile()">
          <i class="fas fa-edit mr-3 text-gray-600"></i>
          <span>Edit Profile</span>
        </button>
        <button class="w-full text-left flex items-center p-3 hover:bg-gray-50 rounded" onclick="showMyOrders()">
          <i class="fas fa-box mr-3 text-gray-600"></i>
          <span>My Orders</span>
        </button>
        <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded">
          <i class="fas fa-heart mr-3 text-gray-600"></i>
          <span>Wishlist</span>
        </a>
        <button class="w-full text-left flex items-center p-3 hover:bg-gray-50 rounded" onclick="loadUserAddresses().then(() => showAddresses())">
          <i class="fas fa-map-marker-alt mr-3 text-gray-600"></i>
          <span>Addresses</span>
        </button>
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
          
          <!-- Existing Addresses Dropdown -->
          <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Existing Address</label>
            <select class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="existingAddress" onchange="selectExistingAddress()">
              <option value="">Select an existing address</option>
            </select>
          </div>
          
          <div class="text-center text-gray-500 text-sm mb-3">OR</div>
          
          <!-- New Address Fields -->
          <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
            <textarea class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent h-20" id="address" placeholder="Enter your full street address" required></textarea>
          </div>
          
          <div class="grid grid-cols-2 gap-3 mb-3">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
              <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="city" placeholder="City" required>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">ZIP Code</label>
              <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="zipCode" placeholder="ZIP Code" required>
            </div>
          </div>
          
          <h6 class="font-semibold mb-3">Payment Information</h6>
          <!-- Stripe Elements Card Input -->
          <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Card Details</label>
            <div id="card-element" class="p-3 border border-gray-300 rounded-lg bg-white">
              <!-- Stripe Elements will create form elements here -->
            </div>
            <div id="card-errors" class="text-red-600 text-sm mt-2 hidden"></div>
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
    let filteredProducts = [];

    // Get CSRF token
    function getCSRFToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    }

    // Initialize the application
    async function initApp() {
      console.log('Initializing app...');
      try {
        await Promise.all([
          loadProducts(),
          loadUserInfo(),
          loadCart(),
          loadUserAddresses()
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
      console.log('Loading products...');
      try {
        const response = await fetch('/api/products', {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': getCSRFToken()
          }
        });
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const parts = await response.json();
        console.log('Products loaded:', parts);
        
        // Transform parts data to match expected format
        products = parts.map((part, index) => ({
          id: part.id,
          name: part.partName,
          price: parseFloat(part.price),
          image: `https://images.unsplash.com/photo-${1558618047 + index}-3c8c76ca7d13?w=300&h=220&fit=crop&auto=format&q=80&seed=${part.id}`,
          description: part.description,
          features: ["High Quality", "OEM Compatible", "Warranty Included", "Fast Shipping"],
          category: part.brand,
          partNumber: part.partNumber,
          model: part.model,
          quantityInStock: part.quantityInStock
        }));
        
        filteredProducts = [...products];
        renderProducts();
      } catch (error) {
        console.error('Failed to load products:', error);
        showNoProducts();
      }
    }

    // Load user information from API
    async function loadUserInfo() {
      console.log('Loading user info...');
      try {
        const response = await fetch('/api/user', {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCSRFToken()
          }
        });
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        user = await response.json();
        console.log('User loaded:', user);
        updateUserDisplay();
      } catch (error) {
        console.error('Failed to load user info:', error);
        user = {
          name: "Guest User",
          email: "guest@example.com",
          phone: "",
          type: "Customer"
        };
        updateUserDisplay();
      }
    }

    // Load cart from database
    async function loadCart() {
      console.log('Loading cart...');
      try {
        const response = await fetch('/api/cart', {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': getCSRFToken()
          }
        });
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const cartItems = await response.json();
        console.log('Cart loaded:', cartItems);
        
        cart = cartItems.map(item => ({
          id: item.part_id,
          name: item.part.partName,
          price: parseFloat(item.part.price),
          image: `https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=300&h=220&fit=crop&auto=format&q=80&seed=${item.part.id}`,
          quantity: item.quantity,
          category: item.part.brand,
          cartItemId: item.id
        }));
        
      } catch (error) {
        console.error('Failed to load cart:', error);
        cart = [];
      }
    }

    // Add product to cart
    async function addToCart(productId, event) {
      console.log('Adding to cart:', productId);
      try {
        const response = await fetch('/api/cart', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': getCSRFToken()
          },
          body: JSON.stringify({
            part_id: productId,
            quantity: 1
          })
        });

        const result = await response.json();
        
        if (!response.ok) {
          throw new Error(result.error || 'Failed to add to cart');
        }
        
        console.log('Added to cart successfully:', result);
        await loadCart();
        updateCartBadge();
        updateCartDisplay();
        
        // Show success animation
        const button = event.target.closest('button');
        if (button) {
          button.classList.add('success-animation');
          setTimeout(() => button.classList.remove('success-animation'), 600);
        }
        
      } catch (error) {
        console.error('Failed to add to cart:', error);
        alert('Failed to add item to cart: ' + error.message);
      }
    }

    // Update quantity
    async function updateQuantity(productId, change) {
      const item = cart.find(item => item.id === productId);
      if (!item) return;
      
      const newQuantity = item.quantity + change;
      
      if (newQuantity <= 0) {
        await removeFromCart(item.cartItemId);
        return;
      }
      
      try {
        const response = await fetch(`/api/cart/${item.cartItemId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': getCSRFToken()
          },
          body: JSON.stringify({
            quantity: newQuantity
          })
        });

        const result = await response.json();
        
        if (!response.ok) {
          throw new Error(result.error || 'Failed to update quantity');
        }
        
        await loadCart();
        updateCartBadge();
        updateCartDisplay();
        
      } catch (error) {
        console.error('Failed to update quantity:', error);
        alert('Failed to update item quantity: ' + error.message);
      }
    }

    // Remove from cart
    async function removeFromCart(cartItemId) {
      try {
        const response = await fetch(`/api/cart/${cartItemId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': getCSRFToken()
            }
        });

        const result = await response.json();
        
        if (!response.ok) {
          throw new Error(result.error || 'Failed to remove from cart');
        }
        
        await loadCart();
        updateCartBadge();
        updateCartDisplay();
        
      } catch (error) {
        console.error('Failed to remove from cart:', error);
        alert('Failed to remove item from cart: ' + error.message);
      }
    }

    // Update user display
    function updateUserDisplay() {
      if (user) {
        document.getElementById('userName').textContent = user.name || 'N/A';
        document.getElementById('userType').textContent = user.type || 'N/A';
        document.getElementById('userEmail').textContent = user.email || 'N/A';
        document.getElementById('userPhone').textContent = user.phone || 'N/A';
      }
    }

    // Show no products message
    function showNoProducts() {
      const grid = document.getElementById('productGrid');
      grid.innerHTML = `
        <div class="col-span-full text-center py-10">
          <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
          <p class="text-gray-600 text-lg">No products available</p>
          <p class="text-gray-500 text-sm">Please check back later or contact support</p>
        </div>
      `;
    }

    // Render products
    function renderProducts() {
      const grid = document.getElementById('productGrid');
      
      if (!filteredProducts.length) {
        grid.innerHTML = `
          <div class="col-span-full text-center py-10">
            <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 text-lg">No products found</p>
          </div>
        `;
        return;
      }

      grid.innerHTML = filteredProducts.map(product => `
        <div class="product-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
          <img src="images/product-image.png" class="w-full h-48 object-cover" loading="lazy">
          <div class="p-4">
            <h5 class="font-semibold text-lg mb-2">${product.name}</h5>
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">${product.description}</p>
            <div class="flex justify-between items-center mb-3">
              <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">${product.category}</span>
              <span class="text-green-600 font-bold text-lg">$${product.price.toFixed(2)}</span>
            </div>
            <div class="flex gap-2">
              <button 
                class="flex-1 bg-blue-600 text-white py-2 px-3 rounded hover:bg-blue-700 transition-colors text-sm"
                onclick="showProductInfo(${product.id})">
                <i class="fas fa-info-circle mr-1"></i>Info
              </button>
              <button 
                class="flex-1 bg-green-600 text-white py-2 px-3 rounded hover:bg-green-700 transition-colors text-sm ${product.quantityInStock <= 0 ? 'opacity-50 cursor-not-allowed' : ''}"
                onclick="addToCart(${product.id}, event)"
                ${product.quantityInStock <= 0 ? 'disabled' : ''}>
                <i class="fas fa-cart-plus mr-1"></i>Add
              </button>
            </div>
            ${product.quantityInStock <= 0 ? '<p class="text-red-500 text-xs mt-2">Out of Stock</p>' : 
              product.quantityInStock <= 5 ? `<p class="text-orange-500 text-xs mt-2">Only ${product.quantityInStock} left!</p>` : ''}
          </div>
        </div>
      `).join('');
    }

    // Show product information
    function showProductInfo(productId) {
      const product = products.find(p => p.id === productId);
      if (!product) {
        console.error('Product not found:', productId);
        return;
      }
      
      currentProduct = product;
      
      document.getElementById('modalTitle').textContent = product.name;
      document.getElementById('modalBody').innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <img src="images/product-image.png" class="w-full rounded-lg">
          </div>
          <div>
            <h4 class="text-2xl font-bold text-green-600 mb-3">${product.price.toFixed(2)}</h4>
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
      
      // Update modal add to cart button
      const modalBtn = document.getElementById('modalAddToCart');
      if (product.quantityInStock <= 0) {
        modalBtn.disabled = true;
        modalBtn.classList.add('opacity-50', 'cursor-not-allowed');
        modalBtn.innerHTML = 'Out of Stock';
      } else {
        modalBtn.disabled = false;
        modalBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        modalBtn.innerHTML = 'Add to Cart';
      }
      
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
            <p class="text-gray-500 text-sm">Add some items to get started!</p>
          </div>
        `;
        checkoutSummary.classList.add('hidden');
        return;
      }
      
      cartItems.innerHTML = cart.map(item => `
        <div class="border-b pb-4 mb-4 last:border-b-0">
          <div class="flex items-center gap-3">
            <div class="flex-1">
              <h6 class="font-semibold">${item.name}</h6>
              <p class="text-gray-600 text-sm">${item.price.toFixed(2)} each</p>
              <p class="text-gray-500 text-xs">${item.category}</p>
            </div>
            <div class="flex items-center gap-2">
              <button class="bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded flex items-center justify-center transition-colors" onclick="updateQuantity(${item.id}, -1)">-</button>
              <span class="w-8 text-center">${item.quantity}</span>
              <button class="bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded flex items-center justify-center transition-colors" onclick="updateQuantity(${item.id}, 1)">+</button>
              <button class="text-red-500 hover:text-red-700 ml-2 transition-colors" onclick="removeFromCart(${item.cartItemId})">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
          <div class="text-right mt-2">
            <span class="text-sm font-semibold">Total: ${(item.price * item.quantity).toFixed(2)}</span>
          </div>
        </div>
      `).join('');
      
      updateCartSummary();
      checkoutSummary.classList.remove('hidden');
    }

    // Update cart summary
    function updateCartSummary() {
      const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
      const shipping = subtotal > 100 ? 0 : 5.99; // Free shipping over $100
      const total = subtotal + shipping;
      
      document.getElementById('subtotal').textContent = `${subtotal.toFixed(2)}`;
      document.getElementById('shipping').textContent = shipping === 0 ? 'FREE' : `${shipping.toFixed(2)}`;
      document.getElementById('total').textContent = `${total.toFixed(2)}`;
      document.getElementById('checkoutSubtotal').textContent = `${subtotal.toFixed(2)}`;
      document.getElementById('checkoutTotal').textContent = `${total.toFixed(2)}`;
    }

    // Show checkout
    async function showCheckout() {
      if (cart.length === 0) {
        alert('Your cart is empty');
        return;
      }

      closeOffcanvas('cartOffcanvas');
      toggleOffcanvas('checkoutOffcanvas');
      
      // Pre-populate user information and initialize Stripe Elements
      if (user) {
        // User info is already loaded, no fields to populate for shipping-only form
      }
      
      // Initialize Stripe Elements after the offcanvas is shown
      setTimeout(() => {
        initializeStripeElements();
        loadAddressesInCheckout();
      }, 100);
    }

    // Updated process payment function
    async function processPayment() {
      try {
        const addressData = {
          address: document.getElementById('address').value,
          city: document.getElementById('city').value,
          zip_code: document.getElementById('zipCode').value
        };

        // Validate required fields
        if (!addressData.address || !addressData.city || !addressData.zip_code) {
          alert('Please fill in all shipping address fields');
          return;
        }

        // Create payment intent
        const response = await fetch('/api/payment/intent', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': getCSRFToken()
          },
          body: JSON.stringify(addressData)
        });

        const intentData = await response.json();
        
        if (!response.ok) {
          throw new Error(intentData.error || 'Failed to create payment intent');
        }

        // Confirm payment with Stripe Elements
        const { error, paymentIntent } = await stripe.confirmCardPayment(intentData.client_secret, {
          payment_method: {
            card: cardElement,
            billing_details: {
              name: user?.name || 'Customer',
              email: user?.email || '',
            }
          }
        });

        if (error) {
          throw new Error(error.message);
        }

        if (paymentIntent.status === 'succeeded') {
          // Confirm the order
          // Success! Clear cart and show confirmation
          cart = [];
          updateCartBadge();
          updateCartDisplay();
          closeOffcanvas('checkoutOffcanvas');

          alert(`Order placed successfully! Order number: ${orderResult.order.order_number}`);
        }
        
      } catch (error) {
        console.error('Payment failed:', error);
        alert('Payment failed: ' + error.message);
        throw error;
      }
    }

    // Filter products
    function filterProducts() {
      const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
      
      if (!searchTerm) {
        filteredProducts = [...products];
      } else {
        filteredProducts = products.filter(product => 
          product.name.toLowerCase().includes(searchTerm) ||
          product.description.toLowerCase().includes(searchTerm) ||
          product.category.toLowerCase().includes(searchTerm) ||
          product.partNumber.toLowerCase().includes(searchTerm)
        );
      }
      
      renderProducts();
    }

    // Initialize Stripe Elements
    let elements;
    let cardElement;

    // Initialize Stripe Elements when checkout opens
    function initializeStripeElements() {
      elements = stripe.elements();
      
      cardElement = elements.create('card', {
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
      
      cardElement.mount('#card-element');
      
      // Handle card validation errors
      cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
          displayError.textContent = event.error.message;
          displayError.classList.remove('hidden');
        } else {
          displayError.textContent = '';
          displayError.classList.add('hidden');
        }
      });
    }

    // Initialize Stripe
    const stripe = Stripe('{{ config("payment.stripe.public_key") }}');
    let paymentIntent = null;

    // Edit profile functionality (Updated)
    async function editProfile() {
      if (!user) {
        alert('User information not available');
        return;
      }

      const name = prompt('Enter your name:', user.name || '');
      if (!name || name.trim() === '') return;

      const email = prompt('Enter your email:', user.email || '');
      if (!email || email.trim() === '') return;

      const phone = prompt('Enter your phone:', user.phone || '');
      if (!phone || phone.trim() === '') return;
      
      try {
        const response = await fetch('/api/user', {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': getCSRFToken()
          },
          body: JSON.stringify({
            customerName: name.trim(),
            email: email.trim(),
            contactNumber: phone.trim()
          })
        });

        const result = await response.json();
        
        if (!response.ok) {
          throw new Error(result.error || 'Failed to update profile');
        }
        
        // Update local user object
        user.name = name.trim();
        user.email = email.trim();
        user.phone = phone.trim();
        
        updateUserDisplay();
        alert('Profile updated successfully!');
        
      } catch (error) {
        console.error('Failed to update profile:', error);
        alert('Failed to update profile: ' + error.message);
      }
    }

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

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM loaded, initializing...');
      
      // Checkout form submission
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

      // Modal add to cart button
      const modalAddToCart = document.getElementById('modalAddToCart');
      if (modalAddToCart) {
        modalAddToCart.addEventListener('click', function() {
          if (currentProduct && currentProduct.quantityInStock > 0) {
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

      // Global variables for addresses
      let userAddresses = [];
      let selectedAddressId = null;

      // Load user addresses
      async function loadUserAddresses() {
        try {
          const response = await fetch('/api/customer/addresses', {
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': getCSRFToken()
            }
          });
          
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          
          userAddresses = await response.json();
          console.log('Addresses loaded:', userAddresses);
          
        } catch (error) {
          console.error('Failed to load addresses:', error);
          userAddresses = [];
        }
      }

      // Show addresses in account offcanvas
      function showAddresses() {
        const addressesHTML = userAddresses.length > 0 ? 
          userAddresses.map(address => `
            <div class="bg-gray-50 rounded-lg p-3 mb-3 border">
              <div class="flex justify-between items-start">
                <div class="flex-1">
                  <p class="font-medium">${address.address}</p>
                  <p class="text-sm text-gray-600">${address.city}, ${address.zip_code}</p>
                </div>
                <div class="flex gap-2">
                  <button class="text-blue-600 hover:text-blue-800 text-sm" onclick="editAddress(${address.id})">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="text-red-600 hover:text-red-800 text-sm" onclick="deleteAddress(${address.id})">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          `).join('') :
          '<p class="text-gray-500 text-center py-4">No addresses saved</p>';

        // Update the account offcanvas to show addresses
        const accountOffcanvas = document.getElementById('accountOffcanvas');
        const addressesSection = `
          <div id="addressesView" style="display: none;">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 flex justify-between items-center">
              <h5 class="text-lg font-semibold">
                <button onclick="showAccountMain()" class="mr-2 hover:text-gray-200">
                  <i class="fas fa-arrow-left"></i>
                </button>
                My Addresses
              </h5>
              <button class="text-white hover:text-gray-200" onclick="closeOffcanvas('accountOffcanvas')">
                <i class="fas fa-times"></i>
              </button>
            </div>
            <div class="p-4">
              <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors mb-4" onclick="addNewAddress()">
                <i class="fas fa-plus mr-2"></i>Add New Address
              </button>
              <div id="addressesList">
                ${addressesHTML}
              </div>
            </div>
          </div>
        `;

        // Add addresses section if it doesn't exist
        if (!document.getElementById('addressesView')) {
          accountOffcanvas.insertAdjacentHTML('beforeend', addressesSection);
        } else {
          document.getElementById('addressesList').innerHTML = addressesHTML;
        }

        // Hide main account view and show addresses
        document.querySelector('#accountOffcanvas > div:nth-child(2)').style.display = 'none';
        document.getElementById('addressesView').style.display = 'block';
      }

      // Show main account view
      function showAccountMain() {
        document.querySelector('#accountOffcanvas > div:nth-child(2)').style.display = 'block';
        if (document.getElementById('addressesView')) {
          document.getElementById('addressesView').style.display = 'none';
        }
      }

      // Add new address
      function addNewAddress() {
        const address = prompt('Enter your address:');
        if (!address || address.trim() === '') return;

        const city = prompt('Enter your city:');
        if (!city || city.trim() === '') return;

        const zipCode = prompt('Enter your ZIP code:');
        if (!zipCode || zipCode.trim() === '') return;

        saveAddress({
          address: address.trim(),
          city: city.trim(),
          zip_code: zipCode.trim()
        });
      }

      // Edit address
      function editAddress(addressId) {
        const address = userAddresses.find(addr => addr.id === addressId);
        if (!address) return;

        const newAddress = prompt('Enter your address:', address.address);
        if (!newAddress || newAddress.trim() === '') return;

        const newCity = prompt('Enter your city:', address.city);
        if (!newCity || newCity.trim() === '') return;

        const newZipCode = prompt('Enter your ZIP code:', address.zip_code);
        if (!newZipCode || newZipCode.trim() === '') return;

        updateAddress(addressId, {
          address: newAddress.trim(),
          city: newCity.trim(),
          zip_code: newZipCode.trim()
        });
      }

      // Save new address
      async function saveAddress(addressData) {
        try {
          const response = await fetch('/api/customer/addresses', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': getCSRFToken()
            },
            body: JSON.stringify(addressData)
          });

          const result = await response.json();
          
          if (!response.ok) {
            throw new Error(result.message || 'Failed to save address');
          }
          
          await loadUserAddresses();
          showAddresses();
          alert('Address added successfully!');
          
        } catch (error) {
          console.error('Failed to save address:', error);
          alert('Failed to save address: ' + error.message);
        }
      }

      // Update address
      async function updateAddress(addressId, addressData) {
        try {
          const response = await fetch(`/api/customer/addresses/${addressId}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': getCSRFToken()
            },
            body: JSON.stringify(addressData)
          });

          const result = await response.json();
          
          if (!response.ok) {
            throw new Error(result.message || 'Failed to update address');
          }
          
          await loadUserAddresses();
          showAddresses();
          alert('Address updated successfully!');
          
        } catch (error) {
          console.error('Failed to update address:', error);
          alert('Failed to update address: ' + error.message);
        }
      }

      // Delete address
      async function deleteAddress(addressId) {
        if (!confirm('Are you sure you want to delete this address?')) return;

        try {
          const response = await fetch(`/api/customer/addresses/${addressId}`, {
            method: 'DELETE',
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': getCSRFToken()
            }
          });

          const result = await response.json();
          
          if (!response.ok) {
            throw new Error(result.message || 'Failed to delete address');
          }
          
          await loadUserAddresses();
          showAddresses();
          alert('Address deleted successfully!');
          
        } catch (error) {
          console.error('Failed to delete address:', error);
          alert('Failed to delete address: ' + error.message);
        }
      }

      // Load existing addresses in checkout
      function loadAddressesInCheckout() {
        const existingAddressSelect = document.getElementById('existingAddress');
        if (!existingAddressSelect) return;

        existingAddressSelect.innerHTML = '<option value="">Select an existing address</option>' +
          userAddresses.map(address => 
            `<option value="${address.id}" data-address="${address.address}" data-city="${address.city}" data-zip="${address.zip_code}">
              ${address.address}, ${address.city}, ${address.zip_code}
            </option>`
          ).join('');
      }

      // Select existing address in checkout
      function selectExistingAddress() {
        const select = document.getElementById('existingAddress');
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption.value) {
          document.getElementById('address').value = selectedOption.dataset.address;
          document.getElementById('city').value = selectedOption.dataset.city;
          document.getElementById('zipCode').value = selectedOption.dataset.zip;
          selectedAddressId = parseInt(selectedOption.value);
        }
      }

      // Initialize the app
      initApp();
    });
  </script>

</body>
</html>
