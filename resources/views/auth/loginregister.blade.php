<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LuxAuto - Login & Registration</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  @vite('resources/css/app.css')
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

    .auth-hero {
      background-image: url('images/stretch-image5.png');
      background-position: center;
      background-size: cover;
	  padding-top: 100px;
	  padding-bottom: 100px;
    }

    .auth-hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.3);
      z-index: 1;
    }

    .auth-tab {
      flex: 1;
      padding: 1.25rem;
      text-align: center;
      color: white;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      background-color: #007bff; /* Light blue default */
      font-weight: normal;
      transition: background-color 0.3s ease;
      z-index: 2;
    }

    .auth-tab.active {
      background-color: #0056b3; /* Darker blue when active */
      font-weight: bold;
    }

    .auth-tab::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      transition: left 0.3s ease;
      z-index: 1;
    }

    .auth-tab:hover::before {
      left: 0;
    }

    .auth-tab span,
    .auth-tab i {
      position: relative;
      z-index: 2;
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

    .auth-form {
		display: none;
	  }
	  
	.auth-form.active {
		display: block;
	  }
	  

  .btn-auth {
    background-color: #007bff; /* Default blue */
    border: none;
    border-radius: 1rem;
    padding: 1rem 2rem;
    color: white;
    font-weight: bold;
    font-size: 1rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

    .btn-auth::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #28a745, #20c997);
      transition: left 0.4s ease;
    }

    .btn-auth:hover::before {
      left: 0;
    }

    .btn-auth span {
      position: relative;
      z-index: 1;
    }

    .btn-auth:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0, 123, 255, 0.3);
    }

    .btn-auth:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .strength-weak { background: #dc3545; }
    .strength-medium { background: #ffc107; }
    .strength-strong { background: #28a745; }

    @keyframes loadBar {
      0% { width: 0; }
      100% { width: 100%; }
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

    .loader-bar {
      height: 100%;
      width: 0;
      background-color: #007bff;
      animation: loadBar 2s ease-in-out forwards;
      border-radius: 5px;
    }

    .social-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      color: white;
    }

    .divider::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 1px;
      background: #e0e0e0;
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
          <a class="text-blue-500 font-bold text-xl" href="#">LuxAuto</a>
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
              <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/contactus"><span>Contact Us</span></a></li>
              <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5 bg-blue-500 text-white" href="/loginregister"><span>Login</span></a></li>
            </ul>
          </div>
        </div>
        <!-- Mobile menu -->
        <div class="lg:hidden hidden mt-4" id="mobile-menu">
          <ul class="flex flex-col space-y-2">
            <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/"><span>Home</span></a></li>
            <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/aboutus"><span>About Us</span></a></li>
            <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/shop"><span>Shop</span></a></li>
            <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5" href="/contactus"><span>Contact Us</span></a></li>
            <li><a class="navbar-nav nav-link nav-link-hover block px-6 py-2 text-center min-w-max rounded transition-all duration-300 mx-0.5 bg-blue-500 text-white" href="/loginregister"><span>Login</span></a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Auth Hero Section -->
  <div class="auth-hero relative min-h-screen overflow-hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-black bg-opacity-30 z-10"></div>
    <div class="relative z-20 bg-white bg-opacity-95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden w-full max-w-4xl mx-5">
      <div class="flex bg-gradient-to-br from-accent to-blue-700">
        <div class="auth-tab flex-1 p-5 text-center text-white cursor-pointer transition-all duration-300 relative overflow-hidden font-bold" data-tab="login">
          <i class="fas fa-sign-in-alt mr-2 text-lg"></i>
          <span>Login</span>
        </div>
        <div class="auth-tab flex-1 p-5 text-center text-white cursor-pointer transition-all duration-300 relative overflow-hidden" data-tab="register">
          <i class="fas fa-user-plus mr-2 text-lg"></i>
          <span>Register</span>
        </div>
      </div>

      <div class="p-10">
        <!-- Login Form -->
        <form class="auth-form block" id="loginForm">
          <h2 class="text-center mb-6 text-blue-500 text-2xl font-semibold">Welcome Back!</h2>
          
          <div class="relative mb-6">
            <input type="email" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="loginEmail" placeholder="Email Address" required>
            <i class="fas fa-envelope absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 transition-all duration-300"></i>
            <div class="validation-message text-sm mt-1 transition-all duration-300" id="loginEmailMsg"></div>
          </div>

          <div class="relative mb-6">
            <input type="password" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="loginPassword" placeholder="Password" required>
            <i class="fas fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer transition-colors duration-300 hover:text-accent" id="loginPasswordToggle"></i>
            <div class="validation-message text-sm mt-1 transition-all duration-300" id="loginPasswordMsg"></div>
          </div>

          <div class="flex items-center justify-between mb-4">
            <label class="flex items-center">
              <input class="mr-2" type="checkbox" id="rememberMe">
              <span>Remember me</span>
            </label>
            <a href="#" class="text-accent hover:underline">Forgot Password?</a>
          </div>

          <button type="submit" class="btn-auth w-full bg-gradient-to-br from-accent to-blue-700 border-none rounded-xl py-4 px-8 text-white font-bold text-base transition-all duration-300 relative overflow-hidden hover:transform hover:-translate-y-0.5" id="loginBtn">
            <span>Sign In</span>
          </button>

          <div class="divider text-center my-5 relative">
            <span class="bg-white px-5 text-gray-400">Or continue with</span>
          </div>

          <div class="text-center my-5">
            <a href="#" class="social-btn inline-block w-12 h-12 rounded-full mx-2 leading-12 text-white no-underline transition-all duration-300 relative overflow-hidden bg-red-600 content-center"><i class="fab fa-google"></i></a>
            <a href="#" class="social-btn inline-block w-12 h-12 rounded-full mx-2 leading-12 text-white no-underline transition-all duration-300 relative overflow-hidden bg-blue-800 content-center"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-btn inline-block w-12 h-12 rounded-full mx-2 leading-12 text-white no-underline transition-all duration-300 relative overflow-hidden bg-blue-400 content-center"><i class="fab fa-twitter"></i></a>
          </div>
        </form>

        <!-- Register Form -->
        <form class="auth-form hidden" id="registerForm">
          <h2 class="text-center mb-6 text-blue-500 text-2xl font-semibold">Create Account</h2>
          
          <div class="flex flex-wrap -mx-2">
            <div class="w-full md:w-1/2 px-2">
              <div class="relative mb-6">
                <input type="text" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="firstName" placeholder="First Name" required>
                <i class="fas fa-user absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 transition-all duration-300"></i>
                <div class="validation-message text-sm mt-1 transition-all duration-300" id="firstNameMsg"></div>
              </div>
            </div>
            <div class="w-full md:w-1/2 px-2">
              <div class="relative mb-6">
                <input type="text" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="lastName" placeholder="Last Name" required>
                <i class="fas fa-user absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 transition-all duration-300"></i>
                <div class="validation-message text-sm mt-1 transition-all duration-300" id="lastNameMsg"></div>
              </div>
            </div>
          </div>

          <div class="relative mb-6">
            <input type="email" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="registerEmail" placeholder="Email Address" required>
            <i class="fas fa-envelope absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 transition-all duration-300"></i>
            <div class="validation-message text-sm mt-1 transition-all duration-300" id="registerEmailMsg"></div>
          </div>

          <div class="relative mb-6">
            <input type="tel" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="phone" placeholder="Phone Number" required>
            <i class="fas fa-phone absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 transition-all duration-300"></i>
            <div class="validation-message text-sm mt-1 transition-all duration-300" id="phoneMsg"></div>
          </div>

          <div class="w-full md:w-1/2 px-2">
            <div class="relative mb-6">
              <input type="text" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="userName" placeholder="User Name" required>
              <i class="fas fa-user absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 transition-all duration-300"></i>
              <div class="validation-message text-sm mt-1 transition-all duration-300" id="usernameMsg"></div>
            </div>
          </div>

          <div class="relative mb-6">
            <input type="password" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="registerPassword" placeholder="Password" required>
            <i class="fas fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer transition-colors duration-300 hover:text-accent" id="registerPasswordToggle"></i>
            <div class="validation-message text-sm mt-1 transition-all duration-300" id="registerPasswordMsg"></div>
            <div class="h-1 bg-gray-300 rounded-sm mt-2 overflow-hidden">
              <div class="h-full w-0 rounded-sm transition-all duration-300" id="strengthBar"></div>
            </div>
          </div>

          <div class="relative mb-6">
            <input type="password" class="w-full border-2 border-gray-300 rounded-xl py-4 px-5 text-base transition-all duration-300 bg-white bg-opacity-90 focus:border-accent focus:outline-none focus:ring-2 focus:ring-blue-200 focus:bg-white" id="confirmPassword" placeholder="Confirm Password" required>
            <i class="fas fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer transition-colors duration-300 hover:text-accent" id="confirmPasswordToggle"></i>
            <div class="validation-message text-sm mt-1 transition-all duration-300" id="confirmPasswordMsg"></div>
          </div>

          <div class="mb-4">
            <label class="flex items-start">
              <input class="mr-2 mt-1" type="checkbox" id="agreeTerms" required>
              <span>I agree to the <a href="#" class="text-accent hover:underline">Terms of Service</a> and <a href="#" class="text-accent hover:underline">Privacy Policy</a></span>
            </label>
          </div>

          <button type="submit" class="btn-auth w-full bg-gradient-to-br from-accent to-blue-700 border-none rounded-xl py-4 px-8 text-white font-bold text-base transition-all duration-300 relative overflow-hidden hover:transform hover:-translate-y-0.5" id="registerBtn">
            <span>Create Account</span>
          </button>

          <div class="divider text-center my-5 relative">
            <span class="bg-white px-5 text-gray-400">Or continue with</span>
          </div>

          <div class="text-center my-5">
            <a href="#" class="social-btn inline-block w-12 h-12 rounded-full mx-2 leading-12 text-white no-underline transition-all duration-300 relative overflow-hidden bg-red-600 content-center"><i class="fab fa-google"></i></a>
            <a href="#" class="social-btn inline-block w-12 h-12 rounded-full mx-2 leading-12 text-white no-underline transition-all duration-300 relative overflow-hidden bg-blue-800 content-center"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-btn inline-block w-12 h-12 rounded-full mx-2 leading-12 text-white no-underline transition-all duration-300 relative overflow-hidden bg-blue-400 content-center"><i class="fab fa-twitter"></i></a>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="text-center text-white py-4 mt-5 bg-gray-900">
    &copy; 2024 LuxParts - All rights reserved.
  </footer>


  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function () {
      const tabs = document.querySelectorAll('.auth-tab');
      const forms = document.querySelectorAll('.auth-form');

      tabs.forEach(tab => {
        tab.addEventListener('click', function () {
          const tabName = this.getAttribute('data-tab');

          // Hide all forms and deactivate all tabs
          forms.forEach(f => {
            f.classList.remove('active');
            f.style.display = 'none';
          });
          tabs.forEach(t => t.classList.remove('active'));

          // Show current form and activate current tab
          const currentForm = document.getElementById(tabName + 'Form');
          currentForm.classList.add('active');
          currentForm.style.display = 'block';
          this.classList.add('active');
        });
      });

      // Initialize: Show login form by default
      document.querySelector('.auth-tab[data-tab="login"]').classList.add('active');
      document.getElementById('loginForm').classList.add('active');
      document.getElementById('loginForm').style.display = 'block';
      document.getElementById('registerForm').style.display = 'none';
    });

    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      const mobileMenu = document.getElementById('mobile-menu');
      mobileMenu.classList.toggle('hidden');
    });

    // Password toggle functionality
    function setupPasswordToggle(toggleId, inputId) {
      const toggle = document.getElementById(toggleId);
      const input = document.getElementById(inputId);
      
      toggle.addEventListener('click', function() {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    }

    setupPasswordToggle('loginPasswordToggle', 'loginPassword');
    setupPasswordToggle('registerPasswordToggle', 'registerPassword');
    setupPasswordToggle('confirmPasswordToggle', 'confirmPassword');

    // Validation functions
    function showValidation(elementId, message, isValid) {
      const element = document.getElementById(elementId);
      const msgElement = document.getElementById(elementId + 'Msg');
      
      element.classList.remove('is-valid', 'is-invalid');
      element.classList.add(isValid ? 'is-valid' : 'is-invalid');
      
      msgElement.textContent = message;
      msgElement.classList.remove('success', 'error', 'show');
      msgElement.classList.add(isValid ? 'success' : 'error', 'show');
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

    function validatePassword(password) {
      return {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password),
        special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
      };
    }

    function getPasswordStrength(password) {
      const checks = validatePassword(password);
      const score = Object.values(checks).filter(Boolean).length;
      
      if (score < 3) return { strength: 'weak', width: 33 };
      if (score < 5) return { strength: 'medium', width: 66 };
      return { strength: 'strong', width: 100 };
    }

    // Real-time validation
    document.getElementById('loginEmail').addEventListener('input', function() {
      const email = this.value;
      if (email.length === 0) return;
      
      if (validateEmail(email)) {
        showValidation('loginEmail', 'Valid email address', true);
      } else {
        showValidation('loginEmail', 'Please enter a valid email address', false);
      }
    });

    document.getElementById('registerEmail').addEventListener('input', function() {
      const email = this.value;
      if (email.length === 0) return;
      
      if (validateEmail(email)) {
        showValidation('registerEmail', 'Valid email address', true);
      } else {
        showValidation('registerEmail', 'Please enter a valid email address', false);
      }
    });

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

    document.getElementById('phone').addEventListener('input', function() {
      const phone = this.value;
      if (phone.length === 0) return;
      
      if (validatePhone(phone)) {
        showValidation('phone', 'Valid phone number', true);
      } else {
        showValidation('phone', 'Please enter a valid phone number', false);
      }
    });

    document.getElementById('registerPassword').addEventListener('input', function() {
      const password = this.value;
      const strengthBar = document.getElementById('strengthBar');
      
      if (password.length === 0) {
        strengthBar.style.width = '0%';
        return;
      }
      
      const checks = validatePassword(password);
      const { strength, width } = getPasswordStrength(password);
      
      strengthBar.style.width = width + '%';
      strengthBar.className = 'strength-bar strength-' + strength;
      
      const missingRequirements = [];
      if (!checks.length) missingRequirements.push('8 characters');
      if (!checks.uppercase) missingRequirements.push('uppercase letter');
      if (!checks.lowercase) missingRequirements.push('lowercase letter');
      if (!checks.number) missingRequirements.push('number');
      if (!checks.special) missingRequirements.push('special character');
      
      if (missingRequirements.length === 0) {
        showValidation('registerPassword', 'Strong password!', true);
      } else {
        showValidation('registerPassword', 'Missing: ' + missingRequirements.join(', '), false);
      }
    });

    document.getElementById('confirmPassword').addEventListener('input', function() {
      const password = document.getElementById('registerPassword').value;
      const confirmPassword = this.value;
      
      if (confirmPassword.length === 0) return;
      
      if (password === confirmPassword) {
        showValidation('confirmPassword', 'Passwords match', true);
      } else {
        showValidation('confirmPassword', 'Passwords do not match', false);
      }
    });

    // Form submissions
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const email = document.getElementById('loginEmail').value;
      const password = document.getElementById('loginPassword').value;
      const btn = document.getElementById('loginBtn');
      
      if (!validateEmail(email)) {
        showValidation('loginEmail', 'Please enter a valid email address', false);
        return;
      }
      
      if (password.length === 0) {
        showValidation('loginPassword', 'Password is required', false);
        return;
      }
      
      // Simulate API call
      btn.disabled = true;
      btn.querySelector('span').textContent = 'Signing In...';
      
      setTimeout(() => {
        alert('Login successful! (This is a demo)');
        btn.disabled = false;
        btn.querySelector('span').textContent = 'Sign In';
      }, 2000);
    });

    document.getElementById('registerForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const firstName = document.getElementById('firstName').value;
      const lastName = document.getElementById('lastName').value;
      const email = document.getElementById('registerEmail').value;
      const phone = document.getElementById('phone').value;
      const password = document.getElementById('registerPassword').value;
      const confirmPassword = document.getElementById('confirmPassword').value;
      const agreeTerms = document.getElementById('agreeTerms').checked;
      const btn = document.getElementById('registerBtn');
      
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
        showValidation('registerEmail', 'Please enter a valid email address', false);
        isValid = false;
      }
      
      if (!validatePhone(phone)) {
        showValidation('phone', 'Please enter a valid phone number', false);
        isValid = false;
      }
      
      const passwordChecks = validatePassword(password);
      if (!Object.values(passwordChecks).every(Boolean)) {
        showValidation('registerPassword', 'Password does not meet requirements', false);
        isValid = false;
      }
      
      if (password !== confirmPassword) {
        showValidation('confirmPassword', 'Passwords do not match', false);
        isValid = false;
      }
      
      if (!agreeTerms) {
        alert('Please agree to the terms and conditions');
        isValid = false;
      }
      
      if (!isValid) return;
      
      // Simulate API call
      btn.disabled = true;
      btn.querySelector('span').textContent = 'Creating Account...';
      
      setTimeout(() => {
        alert('Account created successfully! (This is a demo)');
        btn.disabled = false;
        btn.querySelector('span').textContent = 'Create Account';
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