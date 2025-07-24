<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LuxAuto</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
    :root {
      --primary-color: #e0f0ff;
      --accent-color: #007bff;
    }

    body {
      background-color: var(--primary-color);
      color: #333;
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

    .hero {
      position: relative;
      background: url('images/stretch-image5.png') center/cover;
      height: 1200px;
      overflow: hidden;
    }

        /* Add this for the overlay */
    .hero::before {
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
    .hero > * {
        position: relative;
        z-index: 2;
    }

    .hero-overlay {
      position: absolute;
      top: 15%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 10px;
      width: 95%;
      max-width: 1400px;
      box-shadow: 0 4px 20px rgba(0.2, 0.2, 0.2, 0.2);
      z-index: 2;
    }

    .best-sellers-section {
      position: absolute;
      top: 32%;
      left: 0;
      right: 0;
      padding: 40px 0;
      z-index: 3;
      background-color: rgba(255, 255, 255, 0.6);
      box-shadow: 0 4px 20px rgba(0.2, 0.2, 0.2, 0.2);
    }
    
    .best-sellers-section-2 {
      position: absolute;
      top: 75%;
      left: 0;
      right: 0;
      padding: 40px 0;
      z-index: 3;
      background-color: rgba(255, 255, 255, 0.6);
      box-shadow: 0 4px 20px rgba(0.2, 0.2, 0.2, 0.2);
    }

    .best-sellers-title {
      text-align: left;
      font-size: 2rem;
      margin-bottom: 30px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
      color: black;
    }

    .scroll-wrapper {
      width: 100%;
      overflow: hidden;
      position: relative;
    }

    .scroll-boxes {
      display: flex;
      animation: scrollLoop 30s linear infinite;
    }

    .scroll-boxes .card {
      flex: 0 0 auto;
      margin: 0 15px;
      width: 250px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s, box-shadow 0.3s;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .scroll-boxes .card:hover {
      transform: scale(1.05) translateY(-10px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
    }

    .product-card .btn {
      position: relative;
      overflow: hidden;
    }

    .product-card .btn::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, #007bff, #28a745);
      transform: translateX(-100%);
      transition: transform 0.5s ease;
      z-index: 0;
    }

    .product-card .btn:hover::before {
      transform: translateX(0);
    }

    .product-card .btn span {
      position: relative;
      z-index: 1;
    }

    @keyframes scrollLoop {
      0% { transform: translateX(0); }
      100% { transform: translateX(-50%); }
    }

    .scroll-boxes-container {
      display: flex;
      width: 3000px;
      height: 300px;
    }

    .loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      background-color: var(--primary-color);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }

    .tire {
      width: 100px;
      height: 100px;
      background: url('images/tire_rotating-removebg-preview.png') center/contain no-repeat;
      animation: roll 2s linear infinite;
    }

    .loader-bar-wrapper {
      width: 200px;
      height: 10px;
      background-color: #d0e7ff;
      border-radius: 5px;
      overflow: hidden;
      margin: 0 auto;
    }

    .loader-bar {
      height: 100%;
      width: 0;
      background-color: #007bff;
      animation: loadBar 2s ease-in-out forwards;
      border-radius: 5px;
    }

    @keyframes loadBar {
      0% { width: 0; }
      100% { width: 100%; }
    }

    @keyframes roll {
      0% { transform: rotate(0); }
      100% { transform: rotate(360deg); }
    }

    .product-image {
      height: 200px;
      object-fit: cover;
    }
    
    .chat-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1001;
    }

    .chat-window {
      position: absolute;
      bottom: 100px;
      right: 30px;
      width: 350px;
      height: 500px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .chat-header {
      background: linear-gradient(135deg, #007bff, #28a745);
      color: white;
      padding: 15px;
      font-weight: bold;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .chat-messages {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
      background: #f8f9fa;
    }

    .chat-input-area {
      padding: 15px;
      border-top: 1px solid #e9ecef;
      background: white;
    }

    .chat-input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 20px;
      resize: none;
    }

    .send-btn {
      background: var(--accent-color);
      border: none;
      color: white;
      padding: 8px 15px;
      border-radius: 15px;
      margin-top: 10px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .send-btn:hover {
      background: #0056b3;
    }

    @media (max-width: 768px) {
      .chat-window {
        width: 90%;
        right: 5%;
        left: 5%;
      }
      
      .content-overlay {
        padding: 30px 20px;
      }
    }
    
    .chat-icon {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, #007bff, #28a745);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 1000;
      box-shadow: 0 4px 20px rgba(0, 123, 255, 0.4);
      transition: all 0.3s ease;
      animation: pulse 2s infinite;
    }

    .chat-icon:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 25px rgba(0, 123, 255, 0.6);
    }

    .chat-icon svg {
      width: 30px;
      height: 30px;
      fill: white;
    }

    @keyframes pulse {
      0% { box-shadow: 0 4px 20px rgba(0, 123, 255, 0.4); }
      50% { box-shadow: 0 4px 20px rgba(0, 123, 255, 0.8); }
      100% { box-shadow: 0 4px 20px rgba(0, 123, 255, 0.4); }
    }
    
  </style>
</head>
<body>
  <!-- Loader -->
  <div class="loader" id="loader">
    <div>
      <div class="tire mx-auto"></div>
      <div class="loader-bar-wrapper mt-4">
        <div class="loader-bar"></div>
      </div>
    </div>
  </div>

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
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block active bg-accent-blue text-white" href="/"><span>Home</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/aboutus"><span>About Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/shop"><span>Shop</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/contactus"><span>Contact Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/loginregister"><span>Login</span></a></li>
          </ul>
        </div>

        <!-- Mobile navigation -->
        <div class="mobile-menu mt-4">
          <ul class="flex flex-col space-y-2">
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block bg-accent-blue text-white" href="/"><span>Home</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/aboutus"><span>About Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/shop"><span>Shop</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/contactus"><span>Contact Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/loginregister"><span>Login</span></a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Hero Section with Best Sellers -->
  <div class="hero">
    <div class="hero-overlay">
      <h2 class="text-blue-500 text-2xl font-semibold mb-4">Find Your Vehicle Part</h2>
      <form id="searchForm" class="space-y-2">
        <input type="text" id="partNumber" placeholder="Enter part number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">Search</button>
      </form>
      <div id="partInfo" class="mt-3"></div>
    </div>

    <!-- Best Sellers Section -->
    <section class="best-sellers-section">
      <div class="w-full px-4">
        <h2 class="best-sellers-title">Best Sellers</h2>
        <div class="scroll-wrapper">
          <div class="scroll-boxes-container scroll-boxes">
            <div class="card product-card bg-white rounded-lg overflow-hidden">
              <div class="card-img-top product-image bg-gray-200 flex items-center justify-center text-gray-500">Brake Pad Image</div>
              <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Brake Pad</h5>
                <p class="text-gray-600 text-sm mb-2">High-performance brake pad for safe and reliable braking.</p>
                <p class="text-green-500 font-bold mb-3">$25.00</p>
                <a href="#" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full text-center block hover:bg-blue-600 transition-colors"><span>Add to Cart</span></a>
              </div>
            </div>
            <div class="card product-card bg-white rounded-lg overflow-hidden">
              <div class="card-img-top product-image bg-gray-200 flex items-center justify-center text-gray-500">Oil Filter Image</div>
              <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Oil Filter</h5>
                <p class="text-gray-600 text-sm mb-2">Premium oil filter for optimal engine performance.</p>
                <p class="text-green-500 font-bold mb-3">$18.00</p>
                <a href="#" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full text-center block hover:bg-blue-600 transition-colors"><span>Add to Cart</span></a>
              </div>
            </div>
            <div class="card product-card bg-white rounded-lg overflow-hidden">
              <div class="card-img-top product-image bg-gray-200 flex items-center justify-center text-gray-500">Spark Plug Image</div>
              <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Spark Plug</h5>
                <p class="text-gray-600 text-sm mb-2">High-quality spark plug for better ignition.</p>
                <p class="text-green-500 font-bold mb-3">$12.00</p>
                <a href="#" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full text-center block hover:bg-blue-600 transition-colors"><span>Add to Cart</span></a>
              </div>
            </div>
            <div class="card product-card bg-white rounded-lg overflow-hidden">
              <div class="card-img-top product-image bg-gray-200 flex items-center justify-center text-gray-500">Air Filter Image</div>
              <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Air Filter</h5>
                <p class="text-gray-600 text-sm mb-2">Clean air filter for improved engine efficiency.</p>
                <p class="text-green-500 font-bold mb-3">$22.00</p>
                <a href="#" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full text-center block hover:bg-blue-600 transition-colors"><span>Add to Cart</span></a>
              </div>
            </div>
            <div class="card product-card bg-white rounded-lg overflow-hidden">
              <div class="card-img-top product-image bg-gray-200 flex items-center justify-center text-gray-500">Battery Image</div>
              <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Car Battery</h5>
                <p class="text-gray-600 text-sm mb-2">Long-lasting battery for reliable vehicle start.</p>
                <p class="text-green-500 font-bold mb-3">$89.00</p>
                <a href="#" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full text-center block hover:bg-blue-600 transition-colors"><span>Add to Cart</span></a>
              </div>
            </div>
            <!-- Repeated to create seamless loop -->
            <div class="card product-card bg-white rounded-lg overflow-hidden">
              <div class="card-img-top product-image bg-gray-200 flex items-center justify-center text-gray-500">Brake Pad Image</div>
              <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Brake Pad</h5>
                <p class="text-gray-600 text-sm mb-2">High-performance brake pad for safe and reliable braking.</p>
                <p class="text-green-500 font-bold mb-3">$25.00</p>
                <a href="#" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full text-center block hover:bg-blue-600 transition-colors"><span>Add to Cart</span></a>
              </div>
            </div>
            <div class="card product-card bg-white rounded-lg overflow-hidden">
              <div class="card-img-top product-image bg-gray-200 flex items-center justify-center text-gray-500">Oil Filter Image</div>
              <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Oil Filter</h5>
                <p class="text-gray-600 text-sm mb-2">Premium oil filter for optimal engine performance.</p>
                <p class="text-green-500 font-bold mb-3">$18.00</p>
                <a href="#" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full text-center block hover:bg-blue-600 transition-colors"><span>Add to Cart</span></a>
              </div>
            </div>
            <div class="card product-card bg-white rounded-lg overflow-hidden">
              <div class="card-img-top product-image bg-gray-200 flex items-center justify-center text-gray-500">Spark Plug Image</div>
              <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Spark Plug</h5>
                <p class="text-gray-600 text-sm mb-2">High-quality spark plug for better ignition.</p>
                <p class="text-green-500 font-bold mb-3">$12.00</p>
                <a href="#" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full text-center block hover:bg-blue-600 transition-colors"><span>Add to Cart</span></a>
              </div>
            </div>
            <div class="card product-card bg-white rounded-lg overflow-hidden">
              <div class="card-img-top product-image bg-gray-200 flex items-center justify-center text-gray-500">Air Filter Image</div>
              <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Air Filter</h5>
                <p class="text-gray-600 text-sm mb-2">Clean air filter for improved engine efficiency.</p>
                <p class="text-green-500 font-bold mb-3">$22.00</p>
                <a href="#" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full text-center block hover:bg-blue-600 transition-colors"><span>Add to Cart</span></a>
              </div>
            </div>
            <div class="card product-card bg-white rounded-lg overflow-hidden">
              <div class="card-img-top product-image bg-gray-200 flex items-center justify-center text-gray-500">Battery Image</div>
              <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Car Battery</h5>
                <p class="text-gray-600 text-sm mb-2">Long-lasting battery for reliable vehicle start.</p>
                <p class="text-green-500 font-bold mb-3">$89.00</p>
                <a href="#" class="btn bg-blue-500 text-white px-4 py-2 rounded w-full text-center block hover:bg-blue-600 transition-colors"><span>Add to Cart</span></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <br>
    <section class="best-sellers-section-2">
      <div class="max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <h3 class="text-blue-500 text-xl font-semibold mb-3">Quality Parts</h3>
            <p class="text-gray-700">We offer only the highest quality vehicle parts from trusted manufacturers.</p>
          </div>
          <div>
            <h3 class="text-blue-500 text-xl font-semibold mb-3">Fast Shipping</h3>
            <p class="text-gray-700">Get your parts delivered quickly with our express shipping options.</p>
          </div>
          <div>
            <h3 class="text-blue-500 text-xl font-semibold mb-3">Expert Support</h3>
            <p class="text-gray-700">Our knowledgeable team is here to help you find the right part for your vehicle.</p>
          </div>
        </div>
      </div>
    </section>
  </div>
  
  <!-- Chat Icon -->
  <div class="chat-icon" onclick="openChat()">
    <svg viewBox="0 0 24 24">
      <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
      <path d="M7 9h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z"/>
    </svg>
  </div>

  <!-- Chat Modal -->
  <div class="chat-modal" id="chatModal" onclick="closeChat(event)">
    <div class="chat-window" onclick="event.stopPropagation()">
      <div class="chat-header">
        <span>Chat with Expert Technician</span>
        <button onclick="closeChat()" class="bg-transparent border-none text-white text-xl hover:bg-red-500 rounded w-8 h-8 flex items-center justify-center">&times;</button>
      </div>
      <div class="chat-messages" id="chatMessages">
        <div class="bg-gray-200 p-3 rounded-lg mb-3">
          <strong>Technician Mike:</strong> Hi! I'm here to help with any mechanical issues or part recommendations. What can I assist you with today?
        </div>
      </div>
      <div class="chat-input-area">
        <textarea class="chat-input" id="chatCustomerId" placeholder="Enter your Customer Id..." rows="1"></textarea>
        <textarea class="chat-input" id="chatInput" placeholder="Describe your mechanical issue..." rows="2"></textarea>
        <button class="send-btn" onclick="sendMessage()">Send Message</button>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center text-white py-4 mt-5 bg-gray-900">
    &copy; 2024 LuxParts - All rights reserved.
  </footer>

  <!-- Scripts -->
  <script>
    function toggleMobileMenu() {
      const mobileMenu = document.getElementById('mobileMenu');
      mobileMenu.classList.toggle('hidden');
    }

    function openChat() {
      document.getElementById('chatModal').style.display = 'block';
    }

    function closeChat(event) {
      if (!event || event.target === document.getElementById('chatModal')) {
        document.getElementById('chatModal').style.display = 'none';
      }
    }

    function sendMessage() {
      const input = document.getElementById('chatInput');
      const customerIdInput = document.getElementById('chatCustomerId');
      const messages = document.getElementById('chatMessages');
      const message = input.value.trim();
      
      if (message) {
        // Add user message
        const userDiv = document.createElement('div');
        userDiv.className = 'bg-blue-500 text-white p-3 rounded-lg mb-3 ml-12 text-right';
        userDiv.innerHTML = `<strong>You:</strong> ${message}`;
        messages.appendChild(userDiv);
        
        // Auto-scroll to bottom
        messages.scrollTop = messages.scrollHeight;
        
        // Clear input
        input.value = '';
        customerIdInput.value = '';
        
        // Simulate technician response
        setTimeout(() => {
          const techDiv = document.createElement('div');
          techDiv.className = 'bg-gray-200 p-3 rounded-lg mb-3';
          techDiv.innerHTML = `<strong>Technician Mike:</strong> Thanks for your message! I'll analyze your issue and get back to you with specific solutions and recommendations.`;
          messages.appendChild(techDiv);
          messages.scrollTop = messages.scrollHeight;
        }, 1500);
      }
    }

    // Allow Enter key to send message
    document.getElementById('chatInput').addEventListener('keypress', function(e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });

    document.getElementById('chatCustomerId').addEventListener('keypress', function(e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });

    const fakeDatabase = {
      "AX123": { name: "Brake Pad AX123", brand: "Toyota", price: "$45" },
      "BX200": { name: "Oil Filter BX200", brand: "Nissan", price: "$18" },
      "CX300": { name: "Spark Plug CX300", brand: "Honda", price: "$12" },
      "DX400": { name: "Air Filter DX400", brand: "Ford", price: "$22" }
    };

    document.getElementById("searchForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const partNumber = document.getElementById("partNumber").value.trim().toUpperCase();
      const part = fakeDatabase[partNumber];
      const output = document.getElementById("partInfo");
      if (part) {
        output.innerHTML = `<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded"><strong>${part.name}</strong><br>Brand: ${part.brand}<br>Price: ${part.price}</div>`;
      } else {
        output.innerHTML = `<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Part not found. Try: AX123, BX200, CX300, or DX400</div>`;
      }
    });

    window.addEventListener("load", () => {
      setTimeout(() => {
        document.getElementById("loader").style.display = "none";
      }, 2000);
    });
  </script>
</body>
</html>
