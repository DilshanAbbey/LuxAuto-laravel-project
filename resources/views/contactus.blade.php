<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LuxParts - Contact Us</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'primary-bg': '#e0f0ff',
            'accent': '#007bff',
            'success': '#28a745',
            'error': '#dc3545'
          },
          fontFamily: {
            'sans': ['Segoe UI', 'Tahoma', 'Geneva', 'Verdana', 'sans-serif']
          }
        }
      }
    }
  </script>
  <style>
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

    .contact-hero {
      background-image: url('images/stretch-image5.png');
      background-position: center;
      background-size: cover;
    }

    .contact-hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.3);
      z-index: 1;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .contact-form {
      animation: fadeInUp 0.6s ease;
    }

    .contact-info {
      animation: fadeInUp 0.8s ease;
    }

    .btn-contact::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #28a745, #20c997);
      transition: left 0.4s ease;
    }

    .btn-contact:hover::before {
      left: 0;
    }

    .btn-contact span {
      position: relative;
      z-index: 1;
    }

    .btn-contact:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0, 123, 255, 0.3);
    }

    .btn-contact:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    @keyframes roll {
      0% { transform: rotate(0); }
      100% { transform: rotate(360deg); }
    }

    .tire {
      width: 100px;
      height: 100px;
      background: url('images/tire_rotating-removebg-preview.png') center/contain no-repeat;
      animation: roll 2s linear infinite;
    }

    @keyframes loadBar {
      0% { width: 0; }
      100% { width: 100%; }
    }

    .loader-bar {
      height: 100%;
      width: 0;
      background-color: #007bff;
      animation: loadBar 2s ease-in-out forwards;
      border-radius: 5px;
    }

    .validation-message {
      transition: all 0.3s ease;
      opacity: 0;
      transform: translateY(-10px);
    }

    .validation-message.show {
      opacity: 1;
      transform: translateY(0);
    }

    .contact-icon {
      transition: all 0.3s ease;
    }

    .contact-icon:hover {
      transform: scale(1.1);
      color: #007bff;
    }

    .info-card {
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
    }

    .info-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .map-container {
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body class="bg-primary-bg text-gray-800 font-sans">
  <!-- Loader -->
  <div class="fixed top-0 left-0 w-full h-screen bg-primary-bg flex items-center justify-center z-50" id="loader">
    <div>
      <div class="tire mx-auto"></div>
      <div class="w-48 h-2.5 bg-blue-100 rounded-full overflow-hidden mx-auto mt-4">
        <div class="loader-bar"></div>
      </div>
    </div>
  </div>

  <!-- Navigation -->
  <header class="p-3 bg-blue-500">
    <nav class="bg-white shadow-sm p-3">
      <div class="container mx-auto">
        <div class="flex items-center justify-between">
          <a class="text-blue-500 font-bold text-xl" href="#">LuxParts</a>
          <button class="lg:hidden block" type="button" id="mobile-menu-button">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
          <div class="hidden lg:flex" id="navbar-nav">
            <ul class="flex space-x-1">
              <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/"><span>Home</span></a></li>
              <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/aboutus"><span>About Us</span></a></li>
              <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/shop"><span>Shop</span></a></li>
              <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5 bg-blue-500 text-white" href="/contactus"><span>Contact Us</span></a></li>
              <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/loginregister"><span>Login</span></a></li>
            </ul>
          </div>
        </div>
        <!-- Mobile menu -->
        <div class="lg:hidden hidden mt-4" id="mobile-menu">
          <ul class="flex flex-col space-y-2">
            <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/"><span>Home</span></a></li>
            <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/aboutus"><span>About Us</span></a></li>
            <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/shop"><span>Shop</span></a></li>
            <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5 bg-blue-500 text-white" href="/contactus"><span>Contact Us</span></a></li>
            <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/loginregister"><span>Login</span></a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Contact Hero Section -->
  <div class="contact-hero relative min-h-screen overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-30 z-10"></div>
    <div class="relative z-20 container mx-auto px-5 py-20">
      
      <!-- Page Title -->
      <div class="text-center mb-16">
        <h1 class="text-5xl font-bold text-white mb-4">Get In Touch</h1>
        <p class="text-xl text-white opacity-90">We'd love to hear from you. Let's start a conversation.</p>
      </div>

      <div class="grid lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
        
        <!-- Contact Form -->
        <div class="contact-form bg-white bg-opacity-95 backdrop-blur-sm rounded-3xl shadow-2xl p-10">
          <h2 class="text-3xl font-bold text-blue-500 mb-8 text-center">Send us a Message</h2>
          
          <form id="contactForm">
            <div class="grid md:grid-cols-2 gap-6 mb-6">
              <div class="relative">
                <input type="text" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="firstName" placeholder="First Name" required>
                <i class="fas fa-user absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <div class="validation-message text-sm mt-1" id="firstNameMsg"></div>
              </div>
              <div class="relative">
                <input type="text" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="lastName" placeholder="Last Name" required>
                <i class="fas fa-user absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <div class="validation-message text-sm mt-1" id="lastNameMsg"></div>
              </div>
            </div>

            <div class="relative mb-6">
              <input type="email" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="email" placeholder="Email Address" required>
              <i class="fas fa-envelope absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              <div class="validation-message text-sm mt-1" id="emailMsg"></div>
            </div>

            <div class="relative mb-6">
              <input type="tel" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="phone" placeholder="Phone Number">
              <i class="fas fa-phone absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              <div class="validation-message text-sm mt-1" id="phoneMsg"></div>
            </div>

            <div class="relative mb-6">
              <select class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="subject" required>
                <option value="">Select Subject</option>
                <option value="general">General Inquiry</option>
                <option value="support">Technical Support</option>
                <option value="sales">Sales & Pricing</option>
                <option value="partnership">Partnership</option>
                <option value="complaint">Complaint</option>
                <option value="other">Other</option>
              </select>
              <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
            </div>

            <div class="relative mb-6">
              <textarea class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white resize-none" id="message" rows="5" placeholder="Your Message" required></textarea>
              <i class="fas fa-comment absolute right-4 top-6 text-gray-400"></i>
              <div class="validation-message text-sm mt-1" id="messageMsg"></div>
            </div>

            <button type="submit" class="btn-contact w-full bg-gradient-to-br from-accent to-blue-700 border-none rounded-xl py-4 px-8 text-white font-bold text-base transition-all duration-300 relative overflow-hidden" id="contactBtn">
              <span>Send Message</span>
            </button>
          </form>
        </div>

        <!-- Contact Information -->
        <div class="contact-info space-y-8">
          <div class="info-card rounded-3xl p-8 shadow-2xl">
            <h3 class="text-2xl font-bold text-blue-500 mb-6">Contact Information</h3>
            
            <div class="space-y-6">
              <div class="flex items-center">
                <div class="contact-icon w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                  <i class="fas fa-map-marker-alt text-white"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-800">Address</h4>
                  <p class="text-gray-600">123 Auto Parts Street, Motor City, MC 12345</p>
                </div>
              </div>

              <div class="flex items-center">
                <div class="contact-icon w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                  <i class="fas fa-phone text-white"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-800">Phone</h4>
                  <p class="text-gray-600">+1 (555) 123-4567</p>
                </div>
              </div>

              <div class="flex items-center">
                <div class="contact-icon w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4">
                  <i class="fas fa-envelope text-white"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-800">Email</h4>
                  <p class="text-gray-600">info@luxparts.com</p>
                </div>
              </div>

              <div class="flex items-center">
                <div class="contact-icon w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mr-4">
                  <i class="fas fa-clock text-white"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-800">Business Hours</h4>
                  <p class="text-gray-600">Mon - Fri: 8:00 AM - 6:00 PM<br>Sat: 9:00 AM - 4:00 PM</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Social Media -->
          <div class="info-card rounded-3xl p-8 shadow-2xl">
            <h3 class="text-2xl font-bold text-blue-500 mb-6">Follow Us</h3>
            <div class="flex space-x-4">
              <a href="#" class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors duration-300">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center text-white hover:bg-blue-500 transition-colors duration-300">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center text-white hover:bg-pink-700 transition-colors duration-300">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="#" class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center text-white hover:bg-blue-900 transition-colors duration-300">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </div>

          <!-- Map -->
          <div class="map-container">
            <div class="bg-gray-300 h-64 flex items-center justify-center rounded-3xl">
              <div class="text-center text-gray-600">
                <i class="fas fa-map-marked-alt text-4xl mb-2"></i>
                <p>Interactive Map Would Go Here</p>
                <p class="text-sm">123 Auto Parts Street, Motor City</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="text-center text-white py-4 mt-5 bg-gray-900">
    &copy; 2024 LuxParts - All rights reserved.
  </footer>

  <!-- Scripts -->
  <script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      const mobileMenu = document.getElementById('mobile-menu');
      mobileMenu.classList.toggle('hidden');
    });

    // Validation functions
    function showValidation(elementId, message, isValid) {
      const element = document.getElementById(elementId);
      const msgElement = document.getElementById(elementId + 'Msg');
      
      element.classList.remove('border-green-500', 'border-red-500');
      element.classList.add(isValid ? 'border-green-500' : 'border-red-500');
      
      msgElement.textContent = message;
      msgElement.classList.remove('text-green-600', 'text-red-600', 'show');
      msgElement.classList.add(isValid ? 'text-green-600' : 'text-red-600', 'show');
    }

    function validateEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    }

    function validatePhone(phone) {
      const re = /^[\+]?[1-9][\d]{0,15}$/;
      return re.test(phone.replace(/\s/g, ''));
    }

    function validateName(name) {
      return name.trim().length >= 2 && /^[a-zA-Z\s]+$/.test(name);
    }

    // Real-time validation
    document.getElementById('firstName').addEventListener('input', function() {
      const name = this.value;
      if (name.length === 0) return;
      
      if (validateName(name)) {
        showValidation('firstName', 'Valid first name', true);
      } else {
        showValidation('firstName', 'Name must be at least 2 characters and contain only letters', false);
      }
    });

    document.getElementById('lastName').addEventListener('input', function() {
      const name = this.value;
      if (name.length === 0) return;
      
      if (validateName(name)) {
        showValidation('lastName', 'Valid last name', true);
      } else {
        showValidation('lastName', 'Name must be at least 2 characters and contain only letters', false);
      }
    });

    document.getElementById('email').addEventListener('input', function() {
      const email = this.value;
      if (email.length === 0) return;
      
      if (validateEmail(email)) {
        showValidation('email', 'Valid email address', true);
      } else {
        showValidation('email', 'Please enter a valid email address', false);
      }
    });

    document.getElementById('phone').addEventListener('input', function() {
      const phone = this.value;
      if (phone.length === 0) return;
      
      if (validatePhone(phone)) {
        showValidation('phone', 'Valid phone number', true);
      } else {
        showValidation('phone', 'Please enter a valid phone number', false);
      }
    });

    document.getElementById('message').addEventListener('input', function() {
      const message = this.value;
      if (message.length === 0) return;
      
      if (message.trim().length >= 10) {
        showValidation('message', 'Message looks good', true);
      } else {
        showValidation('message', 'Message should be at least 10 characters long', false);
      }
    });

    // Form submission
    document.getElementById('contactForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const firstName = document.getElementById('firstName').value;
      const lastName = document.getElementById('lastName').value;
      const email = document.getElementById('email').value;
      const phone = document.getElementById('phone').value;
      const subject = document.getElementById('subject').value;
      const message = document.getElementById('message').value;
      const btn = document.getElementById('contactBtn');
      
      let isValid = true;
      
      if (!validateName(firstName)) {
        showValidation('firstName', 'Name must be at least 2 characters and contain only letters', false);
        isValid = false;
      }
      
      if (!validateName(lastName)) {
        showValidation('lastName', 'Name must be at least 2 characters and contain only letters', false);
        isValid = false;
      }
      
      if (!validateEmail(email)) {
        showValidation('email', 'Please enter a valid email address', false);
        isValid = false;
      }
      
      if (phone && !validatePhone(phone)) {
        showValidation('phone', 'Please enter a valid phone number', false);
        isValid = false;
      }
      
      if (!subject) {
        alert('Please select a subject');
        isValid = false;
      }
      
      if (message.trim().length < 10) {
        showValidation('message', 'Message should be at least 10 characters long', false);
        isValid = false;
      }
      
      if (!isValid) return;
      
      // Simulate API call
      btn.disabled = true;
      btn.querySelector('span').textContent = 'Sending...';
      
      setTimeout(() => {
        alert('Message sent successfully! We\'ll get back to you soon. (This is a demo)');
        btn.disabled = false;
        btn.querySelector('span').textContent = 'Send Message';
        
        // Reset form
        document.getElementById('contactForm').reset();
        
        // Clear validation messages
        document.querySelectorAll('.validation-message').forEach(msg => {
          msg.classList.remove('show');
          msg.textContent = '';
        });
        
        // Reset input borders
        document.querySelectorAll('input, textarea, select').forEach(input => {
          input.classList.remove('border-green-500', 'border-red-500');
        });
      }, 2000);
    });

    // Loader
    window.addEventListener("load", () => {
      setTimeout(() => {
        document.getElementById("loader").style.display = "none";
      }, 2000);
    });
  </script>
</body>
</html>