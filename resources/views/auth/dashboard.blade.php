

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LuxAuto Administrator Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
      background: linear-gradient(135deg, #e0f0ff 0%, #b3d9ff 100%);
      min-height: 100vh;
    }
    
    .dashboard-overlay {
	  background: url('images/stretch-image5.png') center/cover;
      min-height: 100vh;
    }

	/* Add this for the overlay */
	.dashboard-overlay::before {
		content: "";
		position: fixed;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		background-color: rgba(0, 0, 0, 0.5); /* Black with 50% opacity */
		z-index: 1;
	}

	/* Put your content above the overlay */
	.dashboard-overlay > * {
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
    
    .nav-ripple {
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }
    
    .nav-ripple::before {
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
    
    .nav-ripple:hover::before {
      width: 300px;
      height: 300px;
    }
    
    .nav-ripple:hover {
      color: white !important;
    }
    
    .nav-ripple span {
      position: relative;
      z-index: 1;
    }
    
    .gradient-bg {
      background: linear-gradient(135deg, #007bff, #28a745);
    }
    
    
    
    .glass-effect {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
      animation: fadeIn 0.3s ease-out;
    }
	
	.tab-content {
		display: none;
	}
	  
	.tab-content.active {
		display: block;
	}

	.modal {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      display: none;
    }
	
    .modal.active { display: flex; }
	
  </style>
</head>
<body>
  <div class="dashboard-overlay">
    <!-- Navigation Header -->
    <header class="p-3 bg-accent-blue">
		<nav class="bg-white shadow-lg p-3">
		  <div class="max-w-7xl mx-auto">
			<div class="flex justify-between items-center">
			  <a class="text-accent-blue font-bold text-xl" href="#">LuxAuto</a>
			  
			  <!-- Mobile menu button -->
			  <button class="mobile-menu-button md:hidden text-gray-500 hover:text-gray-700 focus:outline-none" onclick="toggleMobileMenu()">
				<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
				</svg>
			  </button>

			  <!-- Desktop navigation -->
			  <ul class="desktop-nav flex space-x-1">
				<li><a class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block" href="/loginregister"><span>Logout</span></a></li>
			  </ul>
			</div>

			<!-- Mobile navigation -->
			<div class="mobile-menu mt-4">
			  <ul class="flex flex-col space-y-2">
				<li><a class="nav-link-hover px-6 py-2 rounded text-center block" href="/loginregister"><span>Logout</span></a></li>
			  </ul>
			</div>
		  </div>
		</nav>
  </header>

    <div class="container mx-auto px-4 py-6">
      <!-- Administrator Dashboard -->
      <div class="glass-effect rounded-2xl p-8 mb-6 shadow-2xl">
        <div class="gradient-bg rounded-xl p-6 mb-8 text-white">
          <h2 class="text-3xl font-bold mb-2"><i class="fas fa-user-shield mr-3"></i>Administrator Dashboard</h2>
          <p class="text-lg opacity-90">Complete system management and oversight</p>
        </div>

        <!-- Overview Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="text-center">
              <div class="text-4xl font-bold text-blue-600 mb-2" id="totalCustomers">2,456</div>
              <h5 class="text-lg font-semibold text-gray-700 mb-3">Total Customers</h5>
              <i class="fas fa-users text-3xl text-blue-600"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="text-center">
              <div class="text-4xl font-bold text-green-600 mb-2" id="totalEmployees">127</div>
              <h5 class="text-lg font-semibold text-gray-700 mb-3">Total Employees</h5>
              <i class="fas fa-user-tie text-3xl text-green-600"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="text-center">
              <div class="text-4xl font-bold text-cyan-600 mb-2" id="totalProducts">1,834</div>
              <h5 class="text-lg font-semibold text-gray-700 mb-3">Products in Stock</h5>
              <i class="fas fa-boxes text-3xl text-cyan-600"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="text-center">
              <div class="text-4xl font-bold text-yellow-600 mb-2" id="totalJobs">43</div>
              <h5 class="text-lg font-semibold text-gray-700 mb-3">Active Jobs</h5>
              <i class="fas fa-tools text-3xl text-yellow-600"></i>
            </div>
          </div>
        </div>

			<!-- Tab Navigation -->
		<div class="mb-6 flex flex-wrap gap-4">
		  <button onclick="showTab('customerTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Customer Management</button>
		  <button onclick="showTab('customerDeliveryTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Customer Delivery Management</button>
		  <button onclick="showTab('customerVehicleTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Customer Vehicle Management</button>
		  <button onclick="showTab('vehicleRepairTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Vehicle Repair Management</button>
		  <button onclick="showTab('vehicleServiceTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Vehicle Service Management</button>
		  <button onclick="showTab('customerChatTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Customer Chat Management</button>
		  <button onclick="showTab('employeeTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Employee Management</button>
		  <button onclick="showTab('productTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Product Management</button>
		  <button onclick="showTab('jobTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Job Management</button>
		</div>

		<!-- Customer Management Tab -->
		<div id="customerTab" class="tab-content bg-white p-6 rounded shadow active">
		  <h2 class="text-2xl font-bold text-blue-600 mb-4">Customer Management</h2>
		  <button onclick="openModal('customer')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Customer</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead>
				<tr class="bg-gray-100 text-left text-gray-600">
					<th class="px-4 py-2">ID</th>
					<th class="px-4 py-2">Name</th>
					<th class="px-4 py-2">Email</th>
					<th class="px-4 py-2">Phone</th>
					<th class="px-4 py-2">Username</th>
					<th class="px-4 py-2">Password</th>
					<th class="px-4 py-2">Action</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-200" id="customerDeliveryTable"></tbody>
		  </table>
		</div>
		
		<!-- Customer Delivery Management Tab -->
		<div id="customerDeliveryTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-blue-600 mb-4">Customer Delivery Management</h2>
		  <button onclick="openModal('customer_delivery')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Customer Delivery Info</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead><tr class="bg-gray-100 text-left text-gray-600"><th class="px-4 py-2">ID</th><th class="px-4 py-2">Customer Name</th><th class="px-4 py-2">Address</th><th class="px-4 py-2">Address</th><th class="px-4 py-2">City</th><th class="px-4 py-2">Zip Code</th><th class="px-4 py-2">Action</th></tr></thead>
			<tbody class="divide-y divide-gray-200" id="customerDeliveryTable"></tbody>
		  </table>
		</div>
		
		<!-- Customer Vehicle Management Tab -->
		<div id="customerVehicleTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Customer Vehicle Management</h2>
		  <button onclick="openModal('customer_vehicle')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Customer Vehicle</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead><tr class="bg-gray-100 text-left text-gray-600"><th class="px-4 py-2">Vehicle ID</th><th class="px-4 py-2">Customer Name</th><th class="px-4 py-2">Vehicle Number</th><th class="px-4 py-2">Vehicle Brandf</th><th class="px-4 py-2">Model</th><th class="px-4 py-2">Trim/Edition</th><th class="px-4 py-2">Modal Year</th><th class="px-4 py-2">Description</th><th class="px-4 py-2">Action</th></tr></thead>
			<tbody class="divide-y divide-gray-200" id="customerVehicleTable"></tbody>
		  </table>
		</div>
		
		<!-- Vehicle Repair Management Tab -->
		<div id="vehicleRepairTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Customer Vehicle Repair Management</h2>
		  <button onclick="openModal('Vehicle_Repairs')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Vehicle Repair History</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead><tr class="bg-gray-100 text-left text-gray-600"><th class="px-4 py-2">ID</th><th class="px-4 py-2">Type</th><th class="px-4 py-2">Customer Name</th><th class="px-4 py-2">Date of Schedule</th><th class="px-4 py-2">Description</th><th class="px-4 py-2">Price</th><th class="px-4 py-2">Technician In-Charge</th><th class="px-4 py-2">Action</th></tr></thead>
			<tbody class="divide-y divide-gray-200" id="vehicleRepairTable"></tbody>
		  </table>
		</div>
		
		<!-- Vehicle Service Management Tab -->
		<div id="vehicleServiceTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Customer Vehicle Service Management</h2>
		  <button onclick="openModal('Vehicle_Service')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Vehicle Repair History</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead><tr class="bg-gray-100 text-left text-gray-600"><th class="px-4 py-2">Job ID</th><th class="px-4 py-2">Type</th><th class="px-4 py-2">Customer Name</th><th class="px-4 py-2">Date of Schedule</th><th class="px-4 py-2">Description</th><th class="px-4 py-2">Price</th><th class="px-4 py-2">Technician In-Charge</th><th class="px-4 py-2">Action</th></tr></thead>
			<tbody class="divide-y divide-gray-200" id="vehicleServiceTable"></tbody>
		  </table>
		</div>
		
		<!-- Vehicle Service Management Tab -->
		<div id="customerChatTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Customer Chat Management</h2>
		  <button onclick="openModal('Customer_Chat')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Vehicle Repair History</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead><tr class="bg-gray-100 text-left text-gray-600"><th class="px-4 py-2">Job ID</th><th class="px-4 py-2">Type</th><th class="px-4 py-2">Customer Name</th><th class="px-4 py-2">Date of Schedule</th><th class="px-4 py-2">Description</th><th class="px-4 py-2">Price</th><th class="px-4 py-2">Technician In-Charge</th><th class="px-4 py-2">Action</th></tr></thead>
			<tbody class="divide-y divide-gray-200" id="customerChatTable"></tbody>
		  </table>
		</div>

		<!-- Employee Management Tab -->
		<div id="employeeTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-green-600 mb-4">Employee Management</h2>
		  <button onclick="openModal('employee')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Employee</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead><tr class="bg-gray-100 text-left text-gray-600"><th class="px-4 py-2">ID</th><th class="px-4 py-2">Name</th><th class="px-4 py-2">Role</th><th class="px-4 py-2">Email</th><th class="px-4 py-2">Action</th></tr></thead>
			<tbody class="divide-y divide-gray-200" id="employeeTable"></tbody>
		  </table>
		</div>

		<!-- Product Management Tab -->
		<div id="productTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-cyan-600 mb-4">Product Management</h2>
		   <button onclick="openModal('product')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Product</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead><tr class="bg-gray-100 text-left text-gray-600"><th class="px-4 py-2">Part ID</th><th class="px-4 py-2">Part Name</th><th class="px-4 py-2">Part Number</th><th class="px-4 py-2">Brand</th><th class="px-4 py-2">Model</th><th class="px-4 py-2">Price</th><th class="px-4 py-2">Description</th><th class="px-4 py-2">Quantity in Stock</th><th class="px-4 py-2">Action</th></tr></thead>
			<tbody class="divide-y divide-gray-200" id="productTable"></tbody>
		  </table>
		</div>

		<!-- Job Management Tab -->
		<div id="jobTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Job Management</h2>
		  <button onclick="openModal('job')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Job</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead><tr class="bg-gray-100 text-left text-gray-600"><th class="px-4 py-2">Job ID</th><th class="px-4 py-2">Type</th><th class="px-4 py-2">Customer Name</th><th class="px-4 py-2">Date of Schedule</th><th class="px-4 py-2">Description</th><th class="px-4 py-2">Price</th><th class="px-4 py-2">Technician In-Charge</th><th class="px-4 py-2">Action</th></tr></thead>
			<tbody class="divide-y divide-gray-200" id="jobTable"></tbody>
		  </table>
		</div>
	  </main>
	  
	  <!-- Modal Template -->
	  <div id="formModal" class="modal">
		<div class="bg-white p-6 rounded w-full max-w-lg">
		  <h2 id="modalTitle" class="text-lg font-semibold mb-4"></h2>
		  <form id="dynamicForm" class="space-y-3"></form>
		  <div class="mt-4 flex justify-end">
			<button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded mr-2">Cancel</button>
			<button type="button" onclick="saveForm()" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
		  </div>
		</div>
	  </div>
	</div>
  </div>


	  <script>
		let activeTab = 'customer';
		let formContext = 'customer';
		let editTargetRow = null;
		let editMode = false;
		const tabIds = [
		  'customerTab',
		  'customerDeliveryTab',
		  'customerVehicleTab',
		  'vehicleRepairTab',
		  'vehicleServiceTab',
		  'customerChatTab',
		  'employeeTab',
		  'productTab',
		  'jobTab'
		];
		
		const fields = {
		  customer: ['Customer Name', 'Email', 'Phone'],
		  customer_delivery: ['Customer Name', 'Address', 'City', 'Zip Code'],
		  customer_vehicle: ['Customer Name', 'Vehicle Number', 'Vehicle Brand', 'Vehicle Model', 'Trim/Edition', 'Modal Year', 'Description'],
		  Vehicle_Repairs: ['Customer Name', 'Vehicle Number', 'Repair Date', 'Description', 'Price', 'Technician In-Charge'],
		  Vehicle_Service: ['Customer Name', 'Vehicle Number', 'Service Date', 'Description', 'Price', 'Next Service Date', 'Technician In-Charge'],
		  Repair_Booking: ['Customer Name', 'Vehicle Number', 'Slot Number', 'Date of Schedule', 'Time', 'Technician In-Charge'],
		  Service_Booking: ['Customer Name', 'Vehicle Number', 'Slot Number', 'Date of Schedule', 'Time', 'Technician In-Charge'],
		  Customer_Chat: ['Customer Name', 'Employee Name', 'Date', 'Description', 'Technician In-Charge', 'Status'],
		  employee: ['Employee Name', 'NIC', 'Email', 'Contact', 'Role', 'Salary'],
		  product: ['Part Name', 'Part Number', 'Brand', 'Model', 'Price', 'Description', 'Stock'],
		  job: ['Type', 'Customer', 'Date', 'Description', 'Price', 'Technician']
		};

		function showTab(id) {
		  tabIds.forEach(tab => document.getElementById(tab).classList.remove('active'));
		  document.getElementById(id).classList.add('active');
		  activeTab = id.replace('Tab', '');
		  formContext = activeTab; // <-- set form context when switching tab
		}

		function openModal(context) {
		  editTargetRow = null;
		  editMode = false;
		  formContext = context;
		  generateForm(fields[context]);
		  document.getElementById('modalTitle').innerText = `Add ${capitalize(context)}`;
		  document.getElementById('formModal').classList.add('active');
		}

		function editRow(btn, context) {
		  const row = btn.closest('tr');
		  editTargetRow = row;
		  editMode = true;
		  const values = Array.from(row.children).slice(1, -1).map(td => td.innerText);
		  generateForm(fields[context], values);
		  document.getElementById('modalTitle').innerText = `Edit ${capitalize(context)}`;
		  document.getElementById('formModal').classList.add('active');
		}

		function generateForm(fieldNames, values = []) {
		  const form = document.getElementById('dynamicForm');
		  form.innerHTML = '';
		  fieldNames.forEach((field, i) => {
			form.innerHTML += `<div><label class='block mb-1 text-sm font-medium'>${field}</label><input type='text' name='${field}' value='${values[i] || ''}' class='w-full border px-3 py-2 rounded' required></div>`;
		  });
		}

		function saveForm() {
		  const form = document.getElementById('dynamicForm');
		  const inputs = form.querySelectorAll('input');
		  const data = Array.from(inputs).map(input => input.value);
		  const tableBody = document.getElementById(`${activeTab}Table`);

		  if (editMode && editTargetRow) {
			for (let i = 0; i < data.length; i++) {
			  editTargetRow.children[i + 1].innerText = data[i];
			}
		  } else {
			const row = tableBody.insertRow();
			row.innerHTML = `<td>${tableBody.rows.length + 1}</td>` +
			  data.map(d => `<td>${d}</td>`).join('') +
			  `<td>
				<button onclick="editRow(this, '${formContext}')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
				<button onclick="deleteRow(this)" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
			  </td>`;
		  }

		  closeModal();
		}

		function deleteRow(btn) {
		  btn.closest('tr').remove();
		}

		function closeModal() {
		  document.getElementById('formModal').classList.remove('active');
		  document.getElementById('dynamicForm').reset();
		  editTargetRow = null;
		  editMode = false;
		}

		function capitalize(word) {
		  return word.charAt(0).toUpperCase() + word.slice(1);
		}
	  </script>
	</body>
</html>