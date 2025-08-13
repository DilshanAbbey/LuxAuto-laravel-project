<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>LuxAuto Administrator Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
				<li>
					<form method="POST" action="{{ route('logout') }}" class="inline">
						@csrf
						<button type="submit" class="nav-link-hover px-6 py-2 rounded text-center min-w-[100px] mx-1 block bg-red-500 text-white hover:bg-red-600 transition-colors">
							<span><i class="fas fa-sign-out-alt mr-2"></i>Logout</span>
						</button>
					</form>
				</li>
			  </ul>

			<!-- Mobile navigation -->
			<div class="mobile-menu mt-4">
				<ul class="flex flex-col space-y-2">
					<li>
					<form method="POST" action="{{ route('logout') }}" class="inline">
						@csrf
						<button type="submit" class="nav-link-hover px-6 py-2 rounded text-center block w-full bg-red-500 text-white hover:bg-red-600 transition-colors">
							<span><i class="fas fa-sign-out-alt mr-2"></i>Logout</span>
						</button>
					</form>
					</li>
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
              <div class="text-4xl font-bold text-blue-600 mb-2" id="totalCustomers">1234</div>
              <h5 class="text-lg font-semibold text-gray-700 mb-3">Total Customers</h5>
              <i class="fas fa-users text-3xl text-blue-600"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="text-center">
              <div class="text-4xl font-bold text-green-600 mb-2" id="totalEmployees">345</div>
              <h5 class="text-lg font-semibold text-gray-700 mb-3">Total Employees</h5>
              <i class="fas fa-user-tie text-3xl text-green-600"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="text-center">
              <div class="text-4xl font-bold text-cyan-600 mb-2" id="totalProducts">57</div>
              <h5 class="text-lg font-semibold text-gray-700 mb-3">Products in Stock</h5>
              <i class="fas fa-boxes text-3xl text-cyan-600"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="text-center">
              <div class="text-4xl font-bold text-yellow-600 mb-2" id="totalJobs">67</div>
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
		  <button onclick="showTab('repairBookingTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Repair Booking Management</button>
		  <button onclick="showTab('vehicleServiceTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Vehicle Service Management</button>
		  <button onclick="showTab('serviceBookingTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Service Booking Management</button>
		  <button onclick="showTab('customerChatTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Customer Chat Management</button>
		  <button onclick="showTab('employeeTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Employee Management</button>
		  <button onclick="showTab('productTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Product Management</button>
		  <button onclick="showTab('jobTab')" class="tab-button px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded transition">Job Management</button>
		</div>

		<!-- Customer Management Tab -->
		<div id="customerTab" class="tab-content bg-white xp-6 rounded shadow active">
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
			<tbody class="divide-y divide-gray-200" id="customerTableBody">
				@if(isset($data['customers']) && count($data['customers']) > 0)
				@foreach($data['customers'] as $customer)
				<tr data-id="{{ $customer->id }}">
					<td class="px-4 py-2">{{ $customer->idCustomer }}</td>
					<td class="px-4 py-2">{{ $customer->customerName }}</td>
					<td class="px-4 py-2">{{ $customer->email }}</td>
					<td class="px-4 py-2">{{ $customer->contactNumber }}</td>
					<td class="px-4 py-2">{{ $customer->username }}</td>
					<td class="px-4 py-2">{{ $customer->password }}</td>
					<td class="px-4 py-2">
					<button onclick="editRow(this, 'customer')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
					<button onclick="deleteRow(this, 'customer')" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
					</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="6" class="px-4 py-2 text-center text-gray-500">No customers found</td>
				</tr>
				@endif
			</tbody>
		  </table>
		</div>
		
		<!-- Customer Delivery Management Tab -->
		<div id="customerDeliveryTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-blue-600 mb-4">Customer Delivery Management</h2>
		  <button onclick="openModal('customer_delivery')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Customer Delivery Info</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead>
				<tr class="bg-gray-100 text-left text-gray-600">
					<th class="px-4 py-2">Customer ID</th>
					<th class="px-4 py-2">Address</th>
					<th class="px-4 py-2">City</th>
					<th class="px-4 py-2">Zip Code</th>
					<th class="px-4 py-2">Action</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-200" id="customerDeliveryTable">
				@foreach($data['customerDeliveries'] as $delivery)
				<tr data-id="{{ $delivery->id }}">
					<td class="px-4 py-2">{{ $delivery->customer->idCustomer }}</td>
					<td class="px-4 py-2">{{ $delivery->address }}</td>
					<td class="px-4 py-2">{{ $delivery->city }}</td>
					<td class="px-4 py-2">{{ $delivery->zip_code }}</td>
					<td class="px-4 py-2">
						<button onclick="editRow(this, 'customer_delivery')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
						<button onclick="deleteRow(this, 'customer_delivery')" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		  </table>
		</div>
		
		<!-- Customer Vehicle Management Tab -->
		<div id="customerVehicleTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Customer Vehicle Management</h2>
		  <button onclick="openModal('customer_vehicle')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Customer Vehicle</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead>
				<tr class="bg-gray-100 text-left text-gray-600">
					<th class="px-4 py-2">Vehicle ID</th>
					<th class="px-4 py-2">Customer ID</th>
					<th class="px-4 py-2">Vehicle Number</th>
					<th class="px-4 py-2">Vehicle Brand</th>
					<th class="px-4 py-2">Model</th>
					<th class="px-4 py-2">Trim/Edition</th>
					<th class="px-4 py-2">Modal Year</th>
					<th class="px-4 py-2">Description</th>
					<th class="px-4 py-2">Action</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-200" id="customerVehicleTable">
				@foreach($data['customerVehicles'] as $vehicle)
				<tr data-id="{{ $vehicle->id }}">
					<td class="px-4 py-2">{{ $vehicle->idCustomer_Vehicle }}</td>
					<td class="px-4 py-2">{{ $vehicle->customer->idCustomer }}</td>
					<td class="px-4 py-2">{{ $vehicle->vehicleNumber }}</td>
					<td class="px-4 py-2">{{ $vehicle->vehicleBrand }}</td>
					<td class="px-4 py-2">{{ $vehicle->model }}</td>
					<td class="px-4 py-2">{{ $vehicle->trim/edition }}</td>
					<td class="px-4 py-2">{{ $vehicle->modalYear }}</td>
					<td class="px-4 py-2">{{ $vehicle->description }}</td>
					<td class="px-4 py-2">
						<button onclick="editRow(this, 'customer_vehicle')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
						<button onclick="deleteRow(this, 'customer_vehicle')" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		  </table>
		</div>
		
		<!-- Vehicle Repair Management Tab -->
		<div id="vehicleRepairTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Customer Vehicle Repair Management</h2>
		  <button onclick="openModal('Vehicle_Repairs')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Vehicle Repair History</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead>
				<tr class="bg-gray-100 text-left text-gray-600">
					<th class="px-4 py-2">ID</th>
					<th class="px-4 py-2">Customer ID</th>
					<th class="px-4 py-2">Vehicle Number</th>
					<th class="px-4 py-2">Date of Repair</th>
					<th class="px-4 py-2">Description</th>
					<th class="px-4 py-2">Price</th>
					<th class="px-4 py-2">Technician In-Charge</th>
					<th class="px-4 py-2">Action</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-200" id="vehicleRepairTable">
				@foreach($data['vehicleRepairs'] as $repair)
				<tr data-id="{{ $repair->id }}">
					<td class="px-4 py-2">{{ $repair->idVehicle_Repair }}</td>
					<td class="px-4 py-2">{{ $repair->customer->idCustomer }}</td>
					<td class="px-4 py-2">{{ $repair->vehicle->vehicleNumber }}</td>
					<td class="px-4 py-2">{{ $repair->repairDate->format('Y-m-d') }}</td>
					<td class="px-4 py-2">{{ $repair->description }}</td>
					<td class="px-4 py-2">${{ $repair->price }}</td>
					<td class="px-4 py-2">{{ $repair->technician }}</td>
					<td class="px-4 py-2">
						<button onclick="editRow(this, 'Vehicle_Repairs')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
						<button onclick="deleteRow(this, 'Vehicle_Repairs')" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		  </table>
		</div>

		<!-- Repair Booking Management Tab -->
		<div id="repairBookingTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Customer Repair Booking Management</h2>
		  <button onclick="openModal('Repair_Booking')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Repair Booking</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead>
				<tr class="bg-gray-100 text-left text-gray-600">
					<th class="px-4 py-2">ID</th>
					<th class="px-4 py-2">Slot Number</th>
					<th class="px-4 py-2">Customer ID</th>
					<th class="px-4 py-2">date</th>
					<th class="px-4 py-2">Technician In-Charge</th>
					<th class="px-4 py-2">Action</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-200" id="repairBookingTable">
				@foreach($data['repairBooking'] as $repairBook)
				<tr data-id="{{ $repairBook->id }}">
					<td class="px-4 py-2">{{ $repairBook->idRepair_booking }}</td>
					<td class="px-4 py-2">{{ $repairBook->slotNumber }}</td>
					<td class="px-4 py-2">{{ $repairBook->customer->idCustomer }}</td>
					<td class="px-4 py-2">{{ $repairBook->date->format('Y-m-d') }}</td>
					<td class="px-4 py-2">{{ $repairBook->technician_in_charge }}</td>
					<td class="px-4 py-2">
						<button onclick="editRow(this, 'repair_booking')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
    					<button onclick="deleteRow(this, 'repair_booking')" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		  </table>
		</div>
		
		<!-- Vehicle Service Management Tab -->
		<div id="vehicleServiceTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Customer Vehicle Service Management</h2>
		  <button onclick="openModal('Vehicle_Service')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Vehicle Service History</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead>
				<tr class="bg-gray-100 text-left text-gray-600">
					<th class="px-4 py-2">ID</th>
					<th class="px-4 py-2">Customer Name</th>
					<th class="px-4 py-2">Vehicle Number</th>
					<th class="px-4 py-2">Date of Service</th>
					<th class="px-4 py-2">Description</th>
					<th class="px-4 py-2">Price</th>
					<th class="px-4 py-2">Technician In-Charge</th>
					<th class="px-4 py-2">Action</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-200" id="vehicleServiceTable">
				@foreach($data['vehicleServices'] as $service)
				<tr data-id="{{ $service->id }}">
					<td class="px-4 py-2">{{ $service->idVehicle_Service }}</td>
					<td class="px-4 py-2">{{ $service->customer->idCustomer }}</td>
					<td class="px-4 py-2">{{ $service->vehicle->vehicleNumber }}</td>
					<td class="px-4 py-2">{{ $service->serviceDate->format('Y-m-d') }}</td>
					<td class="px-4 py-2">{{ $service->description }}</td>
					<td class="px-4 py-2">${{ $service->price }}</td>
					<td class="px-4 py-2">{{ $service->technician }}</td>
					<td class="px-4 py-2">
						<button onclick="editRow(this, 'Vehicle_Service')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
						<button onclick="deleteRow(this, 'Vehicle_Service')" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		  </table>
		</div>

		<!-- Service Booking Management Tab -->
		<div id="serviceBookingTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Customer Service Booking Management</h2>
		  <button onclick="openModal('Service_Booking')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Service Booking</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead>
				<tr class="bg-gray-100 text-left text-gray-600">
					<th class="px-4 py-2">ID</th>
					<th class="px-4 py-2">Slot Number</th>
					<th class="px-4 py-2">Customer Name</th>
					<th class="px-4 py-2">Date of Service</th>>
					<th class="px-4 py-2">Technician In-Charge</th>
					<th class="px-4 py-2">Action</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-200" id="serviceBookingTable">
				@foreach($data['serviceBooking'] as $serviceBook)
				<tr data-id="{{ $serviceBook->id }}">
					<td class="px-4 py-2">{{ $serviceBook->idService_booking }}</td>
					<td class="px-4 py-2">{{ $serviceBook->slotNumber }}</td>
					<td class="px-4 py-2">{{ $serviceBook->customer->idCustomer ?? 'N/A' }}</td>
					<td class="px-4 py-2">{{ $serviceBook->date ? $serviceBook->date->format('Y-m-d') : 'N/A' }}</td>
					<td class="px-4 py-2">{{ $serviceBook->technician }}</td>
					<td class="px-4 py-2">
						<button onclick="editRow(this, 'service_booking')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
           				<button onclick="deleteRow(this, 'service_booking')" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		  </table>
		</div>
		
		<!-- Customer Chat Management Tab -->
		<div id="customerChatTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Customer Chat Management</h2>
		  <button onclick="openModal('Customer_Chat')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Customer Chat</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead>
				<tr class="bg-gray-100 text-left text-gray-600">
					<th class="px-4 py-2">ID</th>
					<th class="px-4 py-2">Customer Name</th>
					<th class="px-4 py-2">Date</th>
					<th class="px-4 py-2">Description</th>
					<th class="px-4 py-2">Technician In-Charge</th>
					<th class="px-4 py-2">Status</th>
					<th class="px-4 py-2">Action</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-200" id="customerChatTable">
				@foreach($data['customerChats'] as $chat)
				<tr data-id="{{ $chat->id }}">
					<td class="px-4 py-2">{{ $chat->idCustomer_Chat }}</td>
					<td class="px-4 py-2">{{ $chat->customer->idCustomer }}</td>
					<td class="px-4 py-2">{{ $chat->date->format('Y-m-d') }}</td>
					<td class="px-4 py-2">{{ $chat->description }}</td>
					<td class="px-4 py-2">{{ $chat->employee->employeeName }}</td>
					<td class="px-4 py-2">{{ $chat->status }}</td>
					<td class="px-4 py-2">
						<button onclick="editRow(this, 'Customer_Chat')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
						<button onclick="deleteRow(this, 'Customer_Chat')" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		  </table>
		</div>

		<!-- Employee Management Tab -->
		<div id="employeeTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-green-600 mb-4">Employee Management</h2>
		  <button onclick="openModal('employee')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Employee</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead>
				<tr class="bg-gray-100 text-left text-gray-600">
					<th class="px-4 py-2">ID</th>
					<th class="px-4 py-2">Name</th>
					<th class="px-4 py-2">NIC</th>
					<th class="px-4 py-2">Email</th>
					<th class="px-4 py-2">Contact</th>
					<th class="px-4 py-2">Role</th>
					<th class="px-4 py-2">Salary</th>
					<th class="px-4 py-2">Username</th>
					<th class="px-4 py-2">Password</th>
					<th class="px-4 py-2">Action</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-200" id="employeeTable">
				@foreach($data['employees'] as $employee)
				<tr data-id="{{ $employee->id }}">
					<td class="px-4 py-2">{{ $employee->idEmployee }}</td>
					<td class="px-4 py-2">{{ $employee->employeeName }}</td>
					<td class="px-4 py-2">{{ $employee->nic }}</td>
					<td class="px-4 py-2">{{ $employee->email }}</td>
					<td class="px-4 py-2">{{ $employee->contactNumber }}</td>
					<td class="px-4 py-2">{{ $employee->role }}</td>
					<td class="px-4 py-2">${{ $employee->salary }}</td>
					<td class="px-4 py-2">{{ $employee->username }}</td>
					<td class="px-4 py-2">{{ $employee->password }}</td>
					<td class="px-4 py-2">
						<button onclick="editRow(this, 'employee')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
						<button onclick="deleteRow(this, 'employee')" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		  </table>
		</div>

		<!-- Product Management Tab -->
		<div id="productTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-cyan-600 mb-4">Product Management</h2>
		   <button onclick="openModal('product')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Product</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead>
				<tr class="bg-gray-100 text-left text-gray-600">
					<th class="px-4 py-2">Part ID</th>
					<th class="px-4 py-2">Part Name</th>
					<th class="px-4 py-2">Part Number</th>
					<th class="px-4 py-2">Brand</th>
					<th class="px-4 py-2">Model</th>
					<th class="px-4 py-2">Price</th>
					<th class="px-4 py-2">Description</th>
					<th class="px-4 py-2">Quantity in Stock</th>
					<th class="px-4 py-2">Action</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-200" id="productTable">
				@foreach($data['parts'] as $product)
				<tr data-id="{{ $product->id }}">
					<td class="px-4 py-2">{{ $product->idPart }}</td>
					<td class="px-4 py-2">{{ $product->partName }}</td>
					<td class="px-4 py-2">{{ $product->partNumber }}</td>
					<td class="px-4 py-2">{{ $product->brand }}</td>
					<td class="px-4 py-2">{{ $product->model }}</td>
					<td class="px-4 py-2">${{ $product->price }}</td>
					<td class="px-4 py-2">{{ $product->description }}</td>
					<td class="px-4 py-2">{{ $product->quantityInStock }}</td>
					<td class="px-4 py-2">
						<button onclick="editRow(this, 'product')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
						<button onclick="deleteRow(this, 'product')" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		  </table>
		</div>

		<!-- Job Management Tab -->
		<div id="jobTab" class="tab-content bg-white p-6 rounded shadow">
		  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Job Management</h2>
		  <button onclick="openModal('job')" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Add Job</button>
		  <table class="min-w-full divide-y divide-gray-200">
			<thead>
				<tr class="bg-gray-100 text-left text-gray-600">
					<th class="px-4 py-2">Job ID</th>
					<th class="px-4 py-2">Type</th>
					<th class="px-4 py-2">Customer Name</th>
					<th class="px-4 py-2">Date of Schedule</th>
					<th class="px-4 py-2">Description</th>
					<th class="px-4 py-2">Price</th>
					<th class="px-4 py-2">Technician In-Charge</th>
					<th class="px-4 py-2">Action</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-200" id="jobTable">
				@foreach($data['jobs'] as $job)
				<tr data-id="{{ $job->id }}">
					<td class="px-4 py-2">{{ $job->id }}</td>
					<td class="px-4 py-2">{{ $job->type }}</td>
					<td class="px-4 py-2">{{ $job->customer }}</td>
					<td class="px-4 py-2">{{ $job->date->format('Y-m-d') }}</td>
					<td class="px-4 py-2">{{ $job->description }}</td>
					<td class="px-4 py-2">${{ $job->price }}</td>
					<td class="px-4 py-2">{{ $job->technician }}</td>
					<td class="px-4 py-2">
						<button onclick="editRow(this, 'job')" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
						<button onclick="deleteRow(this, 'job')" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Delete</button>
					</td>
				</tr>
				@endforeach
			</tbody>
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
		// CSRF Token Setup
		const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
		console.log('CSRF Token:', csrfToken);

		let activeTab = 'customer';
		let formContext = 'customer';
		let editTargetRow = null;
		let editMode = false;
		let editId = null;

		const tabIds = [
			'customerTab',
			'customerDeliveryTab', 
			'customerVehicleTab',
			'vehicleRepairTab',
			'vehicleServiceTab',
			'repairBookingTab',
			'serviceBookingTab',
			'customerChatTab',
			'employeeTab',
			'productTab',
			'jobTab'
		];
		
		const fields = {
			customer: ['Customer Name', 'Email', 'Contact Number', 'Username', 'Password'],
			customer_delivery: ['Customer ID', 'Address', 'City', 'Zip Code'],
			customer_vehicle: ['Customer ID', 'Vehicle Number', 'Vehicle Brand', 'Vehicle Model', 'Trim Edition', 'Modal Year', 'Description'],
			vehicle_repair: ['Customer ID', 'Vehicle ID', 'Repair Date', 'Description', 'Price', 'Technician'],
			vehicle_service: ['Customer ID', 'Vehicle ID', 'Service Date', 'Description', 'Price', 'Next Service Date', 'Technician'],
			repair_booking: ['Customer ID', 'Vehicle ID', 'Slot Number', 'Date', 'Time', 'Technician In Charge'],
			service_booking: ['Customer ID', 'Vehicle ID', 'Slot Number', 'Date', 'Time', 'Technician'],
			customer_chat: ['Customer ID', 'Employee ID', 'Date', 'Description', 'Status'],
			employee: ['Employee Name', 'NIC', 'Email', 'Contact Number', 'Role', 'Salary', 'Username', 'Password'],
			part: ['Part Name', 'Part Number', 'Brand', 'Model', 'Price', 'Description', 'Quantity In Stock'],
			job: ['Type', 'Customer', 'Date', 'Description', 'Price', 'Technician']
		};

		const fieldMapping = {
			customer: {
				'Customer_Name': 'customerName',
				'Email': 'email',
				'Contact_Number': 'contactNumber',
				'Username': 'username', 
				'Password': 'password'
			},
			employee: {
				'Employee_Name': 'employeeName',
				'NIC': 'nic',
				'Email': 'email',
				'Contact_Number': 'contactNumber',
				'Role': 'role',
				'Salary': 'salary',
				'Username': 'username',
				'Password': 'password'
			},
			part: {
				'Part_Name': 'partName',
				'Part_Number': 'partNumber',
				'Brand': 'brand',
				'Model': 'model',
				'Price': 'price',
				'Description': 'description',
				'Quantity_In_Stock': 'quantityInStock'
			},
			customer_delivery: {
				'Customer_ID': 'customer_id',
				'Address': 'address',
				'City': 'city',
				'Zip_Code': 'zip_code'
			},
			customer_vehicle: {
				'Customer_ID': 'customer_id',
				'Vehicle_Number': 'vehicleNumber',
				'Vehicle_Brand': 'vehicleBrand',
				'Vehicle_Model': 'model',
				'Trim_Edition': 'trim_edition',
				'Modal_Year': 'modalYear',
				'Description': 'description'
			},
			vehicle_repair: {
				'Customer_ID': 'customer_id',
				'Vehicle_ID': 'vehicle_id',
				'Repair_Date': 'repairDate',
				'Description': 'description',
				'Price': 'price',
				'Technician': 'technician'
			},
			vehicle_service: {
				'Customer_ID': 'customer_id',
				'Vehicle_ID': 'vehicle_id',
				'Service_Date': 'serviceDate',
				'Description': 'description',
				'Price': 'price',
				'Next_Service_Date': 'nextServiceDate',
				'Technician': 'technician'
			},
			repair_booking: {
				'Customer_ID': 'customer_id',
				'Vehicle_ID': 'vehicle_id',
				'Slot_Number': 'slotNumber',
				'Date': 'date',
				'Time': 'time',
				'Technician_In_Charge': 'technician_in_charge'
			},
			service_booking: {
				'Customer_ID': 'customer_id',
				'Vehicle_ID': 'vehicle_id',
				'Slot_Number': 'slotNumber',
				'Date': 'date',
				'Time': 'time',
				'Technician': 'technician'
			},
			customer_chat: {
				'Customer_ID': 'customer_id',
				'Employee_ID': 'employee_id',
				'Date': 'date',
				'Description': 'description',
				'Status': 'status'
			},
			job: {
				'Type': 'type',
				'Customer': 'customer',
				'Date': 'date',
				'Description': 'description',
				'Price': 'price',
				'Technician': 'technician'
			}
		};

		const apiEndpoints = {
			customer: '/dashboard/customers',
			customer_delivery: '/dashboard/customer-deliveries',
			customer_vehicle: '/dashboard/customer-vehicles',
			vehicle_repair: '/dashboard/vehicle-repairs',
			vehicle_service: '/dashboard/vehicle-services',
			repair_booking: '/dashboard/repair-bookings',
			service_booking: '/dashboard/service-bookings',
			customer_chat: '/dashboard/customer-chats',
			employee: '/dashboard/employees',
			part: '/dashboard/parts',
			job: '/dashboard/jobs'
		};

		const tableBodyIds = {
			customer: 'customerTableBody',
			customer_delivery: 'customerDeliveryTable',
			customer_vehicle: 'customerVehicleTable',
			vehicle_repair: 'vehicleRepairTable',
			vehicle_service: 'vehicleServiceTable',
			repair_booking: 'repairBookingTable',
			service_booking: 'serviceBookingTable',
			customer_chat: 'customerChatTable',
			employee: 'employeeTable',
			part: 'productTable',
			job: 'jobTable'
		};

		function showTab(id) {
			tabIds.forEach(tab => document.getElementById(tab)?.classList.remove('active'));
			document.getElementById(id)?.classList.add('active');
			activeTab = id.replace('Tab', '');
			
			// Map tab names to form contexts
			const tabMapping = {
				'customer': 'customer',
				'customerDelivery': 'customer_delivery',
				'customerVehicle': 'customer_vehicle',
				'vehicleRepair': 'vehicle_repair',
				'vehicleService': 'vehicle_service',
				'repairBooking': 'repair_booking',
				'serviceBooking': 'service_booking',
				'customerChat': 'customer_chat',
				'employee': 'employee',
				'product': 'part',
				'job': 'job'
			};
			
			formContext = tabMapping[activeTab] || activeTab;
		}

		function openModal(context) {
			editTargetRow = null;
			editMode = false;
			editId = null;
			formContext = context;
			generateForm(fields[context] || []);
			document.getElementById('modalTitle').innerText = `Add ${capitalize(context.replace('_', ' '))}`;
			document.getElementById('formModal').classList.add('active');
		}

		function editRow(btn, context) {
			const row = btn.closest('tr');
			editTargetRow = row;
			editMode = true;
			editId = row.dataset.id;
			formContext = context;
			
			// Get values from row (skip ID and Action columns)
			const values = Array.from(row.children).slice(1, -1).map(td => {
				let text = td.innerText.trim();
				if (text.startsWith(')) {
					text = text.substring(1);
				}
				return text;
			});
			
			generateForm(fields[context] || [], values);
			document.getElementById('modalTitle').innerText = `Edit ${capitalize(context.replace('_', ' '))}`;
			document.getElementById('formModal').classList.add('active');
		}

		function generateForm(fieldNames, values = []) {
			const form = document.getElementById('dynamicForm');
			form.innerHTML = '';
			fieldNames.forEach((field, i) => {
				const fieldType = field.toLowerCase().includes('date') ? 'date' : 
								field.toLowerCase().includes('time') ? 'time' :
								field.toLowerCase().includes('price') || field.toLowerCase().includes('salary') || field.toLowerCase().includes('stock') || field.toLowerCase().includes('quantity') ? 'number' : 
								field.toLowerCase().includes('email') ? 'email' : 'text';
				const step = fieldType === 'number' && (field.toLowerCase().includes('price') || field.toLowerCase().includes('salary')) ? '0.01' : '';
				
				form.innerHTML += `
				<div>
					<label class='block mb-1 text-sm font-medium'>${field}</label>
					<input type='${fieldType}' name='${field.replace(/\s+/g, '_')}' value='${values[i] || ''}' 
						class='w-full border px-3 py-2 rounded' ${step ? `step='${step}'` : ''} required>
				</div>`;
			});
		}

		async function saveForm() {
			const form = document.getElementById('dynamicForm');
			const formData = new FormData(form);
			
			// Convert FormData to regular object with proper field mapping
			const data = {};
			for (let [key, value] of formData.entries()) {
				// Apply field mapping if it exists for this context
				if (fieldMapping[formContext] && fieldMapping[formContext][key]) {
					data[fieldMapping[formContext][key]] = value;
				} else {
					// Convert field name to snake_case for database compatibility
					const dbFieldName = key.toLowerCase().replace(/\s+/g, '_');
					data[dbFieldName] = value;
				}
			}

			console.log('Form Data:', data);
			console.log('Form Context:', formContext);
			console.log('Edit Mode:', editMode);
			console.log('Edit ID:', editId);

			try {
				let url = apiEndpoints[formContext];
				let method = 'POST';
				
				if (editMode && editId) {
					url += `/${editId}`;
					data._method = 'PUT';
				}

				console.log('Request URL:', url);
				console.log('Sending request...');

				const response = await fetch(url, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': csrfToken,
						'Accept': 'application/json'
					},
					body: JSON.stringify(data)
				});

				console.log('Response Status:', response.status);

				// Log the raw response text first
				const responseText = await response.text();
				console.log('Raw Response:', responseText);

				// Try to parse as JSON
				let result;
				try {
					result = JSON.parse(responseText);
				} catch (parseError) {
					console.error('JSON Parse Error:', parseError);
					console.error('Response was not valid JSON:', responseText);
					alert('Server returned invalid response. Check console for details.');
					return;
				}

				console.log('Parsed Response:', result);

				if (response.ok && result.success) {
					alert(result.message || 'Operation completed successfully!');
					closeModal();
					
					// Reload the page to refresh data
					window.location.reload();
				} else {
					console.error('Error Response:', result);
					alert('Error: ' + (result.message || result.error || 'Something went wrong'));
				}
			} catch (error) {
				console.error('Fetch Error:', error);
				alert('Network error occurred: ' + error.message);
			}
		}

		async function deleteRow(btn, context) {
			if (!confirm('Are you sure you want to delete this record?')) {
				return;
			}

			const row = btn.closest('tr');
			const id = row.dataset.id;

			console.log('Deleting:', context, 'ID:', id);

			try {
				const response = await fetch(`${apiEndpoints[context]}/${id}`, {
					method: 'DELETE',
					headers: {
						'X-CSRF-TOKEN': csrfToken,
						'Accept': 'application/json'
					}
				});

				const responseText = await response.text();
				console.log('Delete Response Text:', responseText);

				let result;
				try {
					result = JSON.parse(responseText);
				} catch (parseError) {
					console.error('Delete JSON Parse Error:', parseError);
					alert('Server returned invalid response for delete operation.');
					return;
				}

				console.log('Delete Response:', result);

				if (response.ok && result.success) {
					row.remove();
					alert(result.message || 'Record deleted successfully!');
					
					// Check if table is empty and add "no records" row
					const tableBodyId = tableBodyIds[context];
					const tableBody = document.getElementById(tableBodyId);
					if (tableBody && tableBody.children.length === 0) {
						const colspan = tableBody.closest('table').querySelector('thead tr').children.length;
						tableBody.innerHTML = `<tr><td colspan="${colspan}" class="px-4 py-2 text-center text-gray-500">No records found</td></tr>`;
					}
				} else {
					console.error('Delete Error:', result);
					alert('Error deleting record: ' + (result.message || result.error || 'Unknown error'));
				}
			} catch (error) {
				console.error('Delete Fetch Error:', error);
				alert('Network error occurred: ' + error.message);
			}
		}

		function closeModal() {
			document.getElementById('formModal').classList.remove('active');
			document.getElementById('dynamicForm').innerHTML = '';
			editTargetRow = null;
			editMode = false;
			editId = null;
		}

		function capitalize(word) {
			return word.charAt(0).toUpperCase() + word.slice(1);
		}

		function toggleMobileMenu() {
			const mobileMenu = document.querySelector('.mobile-menu');
			mobileMenu.classList.toggle('active');
		}

		// Initialize dashboard when page loads
		document.addEventListener('DOMContentLoaded', function() {
			console.log('Dashboard loaded successfully!');
			console.log('CSRF Token:', csrfToken);
			
			// Show customer tab by default
			showTab('customerTab');
		});

		const userRole = '{{ auth()->user()->role }}';

		function initializeRoleBasedUI() {
			const tabsToHide = [];
			
			if (userRole === 'technician') {
				// Technicians can only see their jobs and job history
				tabsToHide = [
					'customerTab', 'customerDeliveryTab', 'employeeTab', 
					'productTab', 'customerChatTab'
				];
			} else if (userRole === 'employee') {
				// Employees cannot see customer management and employee management
				tabsToHide = ['customerTab', 'employeeTab', 'customerChatTab'];
			}
			// Administrators can see all tabs
			
			tabsToHide.forEach(tabId => {
				const tabButton = document.querySelector(`button[onclick="showTab('${tabId}')"]`);
				if (tabButton) {
					tabButton.style.display = 'none';
				}
			});
			
			// Show appropriate default tab
			if (userRole === 'technician') {
				showTab('jobTab');
			} else if (userRole === 'employee') {
				showTab('productTab');
			} else {
				showTab('customerTab');
			}
		}

		// Call this function when page loads
		document.addEventListener('DOMContentLoaded', function() {
			initializeRoleBasedUI();
			console.log('Dashboard loaded for role:', userRole);
		});
	</script>
</body>
</html>