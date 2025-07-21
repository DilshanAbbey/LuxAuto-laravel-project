<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - LuxAuto</title>
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
    body {
      background-color: #e0f0ff;
    }

    .main-content {
      background: url('images/stretch-image5.png') center/cover;
      min-height: 100vh;
    }

    /* Add this for the overlay */
    .main-content::before {
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
    .main-content > * {
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
	
	.main-heading {
		transition: all 0.3s ease;
	}
	
	.main-heading:hover{
		transform: translateY(-10px);
		box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
	}

    .section-card {
      background-color: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .section-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .content-overlay {
      background-color: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
    }

    .stat-box {
      background: linear-gradient(135deg, #007bff, #28a745);
      transition: transform 0.3s ease;
    }

    .stat-box:hover {
      transform: scale(1.05);
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
<body class="text-gray-800">
  <!-- Navigation -->
  <header class="p-3 bg-accent-blue">
    <nav class="bg-white shadow-lg p-3">
      <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center">
          <a class="text-accent-blue font-bold text-xl" href="brandnewcommerce.html">LuxAuto</a>
          
          <!-- Mobile menu button -->
          <button class="mobile-menu-button md:hidden text-gray-500 hover:text-gray-700 focus:outline-none" onclick="toggleMobileMenu()">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>

          <!-- Desktop navigation -->
          <ul class="desktop-nav flex space-x-1">
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/"><span>Home</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block active bg-accent-blue text-white" href="/aboutus"><span>About Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/shop"><span>Shop</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/contactus"><span>Contact Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/loginregister"><span>Login</span></a></li>
          </ul>
        </div>

        <!-- Mobile navigation -->
        <div class="mobile-menu mt-4">
          <ul class="flex flex-col space-y-2">
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/"><span>Home</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block bg-accent-blue text-white" href="/aboutus"><span>About Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/shop"><span>Shop</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/contactus"><span>Contact Us</span></a></li>
            <li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/loginregister"><span>Login</span></a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Main Content -->
  <div class="main-content relative py-20">
	
		<div class="max-w-7xl mx-auto px-4">
		  <!-- Hero Section -->
		  <div class="main-heading content-overlay rounded-2xl shadow-2xl p-12 my-5 text-center">
			<h1 class="text-5xl font-bold text-accent-blue mb-4">About LuxAuto</h1>
			<p class="text-xl text-gray-600">Your trusted partner for premium vehicle parts and automotive solutions since 2010</p>
		  </div>

		  <!-- Company Story -->
		  <div class="section-card rounded-2xl p-8 my-5 shadow-lg">
			<h2 class="text-3xl font-bold text-accent-blue mb-6">Our Story</h2>
			<div class="flex flex-col lg:flex-row items-center gap-8">
			  <div class="lg:w-1.95/3">
				<p class="mb-4 text-gray-700">LuxAuto was founded in 2010 by a passionate team of automotive professionals with a mission to transform the way people purchase parts and maintain their vehicles. What began as a small family-run operation has grown into a full-scale automotive solutions group.</p>
				<p class="mb-4 text-gray-700">Today, LuxAuto operates three specialized branches:</p>
					<ul class="space-y-3">
					  <li class="flex items-start">
						<span><strong class="text-gray-800">LuxParts:</strong> <span class="text-gray-700">our e-commerce platform offering high-quality vehicle parts at competitive prices</span></span>
					  </li>
					  <li class="flex items-start">
						<span><strong class="text-gray-800">LuxService:</strong> <span class="text-gray-700">our vehicle service station providing scheduled maintenance and diagnostics</span></span>
					  </li>
					  <li class="flex items-start">
						<span><strong class="text-gray-800">LuxCare:</strong> <span class="text-gray-700">our expert repair shop specializing in all types of vehicle repairs</span></span>
					  </li>
					</ul><br>
				<p class="mb-4 text-gray-700">With an unwavering focus on quality, trust, and convenience, LuxAuto serves thousands of customers nationwide, ensuring every vehicle receives the care it deserves.</p>
			  </div>
			  <div class="lg:w-1.05/3">
				<img src="images/about-us-main.png" class="w-full rounded-lg" alt="LuxParts Warehouse">
			  </div>
			</div>
		  </div>

		  <!-- Statistics -->
		  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 my-8">
			<div class="stat-box text-white p-8 rounded-2xl text-center">
			  <div class="text-5xl font-bold mb-2">50K+</div>
			  <div class="text-lg">Happy Customers</div>
			</div>
			<div class="stat-box text-white p-8 rounded-2xl text-center">
			  <div class="text-5xl font-bold mb-2">100K+</div>
			  <div class="text-lg">Parts in Stock</div>
			</div>
			<div class="stat-box text-white p-8 rounded-2xl text-center">
			  <div class="text-5xl font-bold mb-2">500+</div>
			  <div class="text-lg">Brands Available</div>
			</div>
			<div class="stat-box text-white p-8 rounded-2xl text-center">
			  <div class="text-5xl font-bold mb-2">14</div>
			  <div class="text-lg">Years Experience</div>
			</div>
		  </div>

		  <!-- Mission & Values -->
		  <div class="section-card rounded-2xl p-8 my-5 shadow-lg">
			<h2 class="text-3xl font-bold text-accent-blue mb-6">Our Mission & Values</h2>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
			  <div>
				<h4 class="text-xl font-semibold text-accent-blue mb-3">Mission</h4>
				<p class="mb-6 text-gray-700">To deliver a complete automotive experience by combining quality parts, professional vehicle services, and expert repairs under one trusted brand.</p>
				
				<h4 class="text-xl font-semibold text-accent-blue mb-3">Vision</h4>
				<p class="text-gray-700">To be the most reliable and recognized automotive solution provider, offering unmatched value through our LuxParts, LuxService, and LuxCare divisions.</p>
			  </div>
			  <div>
				<h4 class="text-xl font-semibold text-accent-blue mb-3">Our Values</h4>
				<ul class="space-y-3">
				  <li class="flex items-start">
					<span class="text-green-500 mr-2">✓</span>
					<span><strong class="text-gray-800">Quality First:</strong> <span class="text-gray-700">Only trusted, tested, and certified parts & service</span></span>
				  </li>
				  <li class="flex items-start">
					<span class="text-green-500 mr-2">✓</span>
					<span><strong class="text-gray-800">Customer Focus:</strong> <span class="text-gray-700">Your satisfaction drives every decision we make</span></span>
				  </li>
				  <li class="flex items-start">
					<span class="text-green-500 mr-2">✓</span>
					<span><strong class="text-gray-800">Expertise:</strong> <span class="text-gray-700">Our trained team ensures top-tier support across all divisions</span></span>
				  </li>
				  <li class="flex items-start">
					<span class="text-green-500 mr-2">✓</span>
					<span><strong class="text-gray-800">Efficiency:</strong> <span class="text-gray-700">Reliable shipping, fast service bookings, and timely repairs</span></span>
				  </li>
				  <li class="flex items-start">
					<span class="text-green-500 mr-2">✓</span>
					<span><strong class="text-gray-800">Integrity:</strong> <span class="text-gray-700">Fair prices and honest recommendations you can trust</span></span>
				  </li>
				</ul>
			  </div>
			</div>
		  </div>
		  
		  <!-- Our Services -->
		  <div class="section-card rounded-2xl p-8 my-5 shadow-lg">
			<h2 class="text-3xl font-bold text-accent-blue mb-6">Our Services</h2>
			<h3 class="text-xl font-semibold text-accent-blue mb-4">LuxParts</h3>
			<div class="flex flex-col lg:flex-row items-center gap-8">
			  <div class="lg:w-2/3">
				<p class="mb-4 text-gray-700">Your one-stop destination for premium automotive parts and accessories. We stock over 50,000 genuine OEM and high-quality aftermarket components for all major vehicle brands. From engine parts and brake systems to suspension components and electrical accessories, we offer competitive pricing with same-day processing and nationwide shipping. Our expert parts specialists provide personalized assistance to ensure you get the exact components your vehicle needs, backed by comprehensive warranties and hassle-free returns.</p>
			  </div>
			  <div class="lg:w-1/3">
				<img src="images/parts-jpeg.jpg" class="w-full rounded-lg" alt="LuxParts Warehouse">
			  </div>
			</div>
			<h3 class="text-xl font-semibold text-accent-blue mt-8 mb-4">LuxService</h3>
			<div class="flex flex-col lg:flex-row items-center gap-8">
			  <div class="lg:w-1/3">
				<img src="images/service.jpg" class="w-full rounded-lg" alt="LuxParts Warehouse">
			  </div>
			  <div class="lg:w-2/3">
				<p class="mb-4 text-gray-700">Professional automotive maintenance services designed to keep your vehicle running at peak performance. Our ASE-certified technicians provide comprehensive preventive care including multi-point inspections, oil changes with premium synthetic lubricants, tire rotations and balancing, brake inspections, fluid top-offs, and seasonal maintenance checks. We use state-of-the-art diagnostic equipment and follow manufacturer specifications to extend your vehicle's lifespan while maintaining warranty coverage. Schedule online or walk-in for convenient, reliable service that fits your busy lifestyle.</p>
			  </div>
			</div>
			<h3 class="text-xl font-semibold text-accent-blue mt-8 mb-4">LuxCare</h3>
			<div class="flex flex-col lg:flex-row items-center gap-8">
			  <div class="lg:w-2/3">
				<p class="mb-4 text-gray-700">Expert automotive repair services for when your vehicle needs more than routine maintenance. Our skilled technicians specialize in complex engine diagnostics and rebuilds, transmission repairs, brake system overhauls, suspension work, electrical troubleshooting, and air conditioning services. Using advanced diagnostic tools and genuine parts, we provide accurate problem identification and lasting solutions. Every repair comes with detailed explanations, transparent pricing, and solid warranties. From minor fixes to major overhauls, we restore your vehicle's performance, safety, and reliability with precision craftsmanship you can trust.</p>
			  </div>
			  <div class="lg:w-1/3">
				<img src="images/repair.jpg" class="w-full rounded-lg" alt="LuxParts Warehouse">
			  </div>
			</div>
		  </div>

		  <!-- Team Section -->
		  <div class="section-card rounded-2xl p-8 my-5 shadow-lg">
			<h2 class="text-3xl font-bold text-accent-blue mb-6 text-center">Meet Our Team</h2>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
			  <div class="text-center">
				<img src="images/CEO.jpeg" alt="CEO" class="w-36 h-36 rounded-full object-cover border-4 border-accent-blue mx-auto mb-4">
				<h5 class="text-xl font-semibold mb-1">John Martinez</h5>
				<p class="text-gray-500 mb-3">Chief Executive Officer</p>
				<p class="text-gray-700">15+ years in automotive industry with expertise in business strategy and customer relations.</p>
			  </div>
			  <div class="text-center">
				<img src="images/CTO.jpg" alt="CTO" class="w-36 h-36 rounded-full object-cover border-4 border-accent-blue mx-auto mb-4">
				<h5 class="text-xl font-semibold mb-1">Sarah Johnson</h5>
				<p class="text-gray-500 mb-3">Chief Technical Officer</p>
				<p class="text-gray-700">Certified automotive technician with 12+ years experience in parts compatibility and technical support.</p>
			  </div>
			  <div class="text-center">
				<img src="images/operations-manager.jpeg" alt="Operations Manager" class="w-36 h-36 rounded-full object-cover border-4 border-accent-blue mx-auto mb-4">
				<h5 class="text-xl font-semibold mb-1">Mike Thompson</h5>
				<p class="text-gray-500 mb-3">Operations Manager</p>
				<p class="text-gray-700">Logistics expert ensuring fast and accurate delivery of parts to customers nationwide.</p>
			  </div>
			</div>
		  </div>

		  <!-- Why Choose Us -->
		  <div class="section-card rounded-2xl p-8 my-5 shadow-lg">
			<h2 class="text-3xl font-bold text-accent-blue mb-6">Why Choose LuxParts?</h2>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
			  <div class="text-center">
				<div class="bg-accent-blue text-white rounded-full w-15 h-15 flex items-center justify-center mx-auto mb-4" style="width: 60px; height: 60px;">
				  <svg width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
					<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
					<path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
				  </svg>
				</div>
				<h5 class="text-xl font-semibold mb-3">Quality Guaranteed</h5>
				<p class="text-gray-700">All parts come with manufacturer warranty and our quality guarantee.</p>
			  </div>
			  <div class="text-center">
				<div class="bg-accent-blue text-white rounded-full w-15 h-15 flex items-center justify-center mx-auto mb-4" style="width: 60px; height: 60px;">
				  <svg width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
					<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.708 2.825L15 11.105V5.383zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741zM1 11.105l4.708-2.897L1 5.383v5.722z"/>
				  </svg>
				</div>
				<h5 class="text-xl font-semibold mb-3">Expert Support</h5>
				<p class="text-gray-700">Our certified technicians provide professional advice and support.</p>
			  </div>
			  <div class="text-center">
				<div class="bg-accent-blue text-white rounded-full w-15 h-15 flex items-center justify-center mx-auto mb-4" style="width: 60px; height: 60px;">
				  <svg width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
					<path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
				  </svg>
				</div>
				<h5 class="text-xl font-semibold mb-3">Fast Shipping</h5>
				<p class="text-gray-700">Quick delivery nationwide with tracking and insurance included.</p>
			  </div>
			</div>
		  </div>
		</div>
	
  </div>

  <!-- Footer -->
  <footer class="text-center text-white py-4 mt-5 bg-gray-800">
    &copy; 2024 LuxParts - All rights reserved.
  </footer>

  <!-- Scripts -->
  <script>
    function toggleMobileMenu() {
      const mobileMenu = document.querySelector('.mobile-menu');
      mobileMenu.classList.toggle('active');
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
      const messages = document.getElementById('chatMessages');
      const message = input.value.trim();
      
      if (message) {
        // Add user message
        const userDiv = document.createElement('div');
        userDiv.style.cssText = 'background: #007bff; color: white; padding: 10px; border-radius: 10px; margin-bottom: 10px; margin-left: 50px; text-align: right;';
        userDiv.innerHTML = `<strong>You:</strong> ${message}`;
        messages.appendChild(userDiv);
        
        // Auto-scroll to bottom
        messages.scrollTop = messages.scrollHeight;
        
        // Clear input
        input.value = '';
        
        // Simulate technician response
        setTimeout(() => {
          const techDiv = document.createElement('div');
          techDiv.style.cssText = 'background: #e9ecef; padding: 10px; border-radius: 10px; margin-bottom: 10px;';
          techDiv.innerHTML = `<strong>Technician Mike:</strong> Thanks for your message! I'll analyze your issue and get back to you with specific part recommendations and troubleshooting steps. Can you provide your vehicle's make, model, and year?`;
          messages.appendChild(techDiv);
          messages.scrollTop = messages.scrollHeight;
        }, 1500);
      }
    }

    // Allow Enter key to send message
    if (document.getElementById('chatInput')) {
      document.getElementById('chatInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
          e.preventDefault();
          sendMessage();
        }
      });
    }
  </script>
</body>
</html>