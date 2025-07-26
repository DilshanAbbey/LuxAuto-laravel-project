<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerDelivery;
use App\Models\CustomerVehicle;
use App\Models\VehicleRepair;
use App\Models\VehicleService;
use App\Models\CustomerChat;
use App\Models\Employee;
use App\Models\Part;
use App\Models\Job;
use Illuminate\Support\Facades\Log;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalCustomers' => Customer::count(),
            'totalEmployees' => Employee::count(),
            'totalParts' => Part::sum('stock'),
            'totalJobs' => Job::count(),
            'customers' => Customer::all(),
            'customerDeliveries' => CustomerDelivery::with('customer')->get(),
            'customerVehicles' => CustomerVehicle::with('customer')->get(),
            'vehicleRepairs' => VehicleRepair::with('customer')->get(),
            'vehicleServices' => VehicleService::with('customer')->get(),
            'customerChats' => CustomerChat::with('customer')->get(),
            'employees' => Employee::all(),
            'parts' => Part::all(),
            'jobs' => Job::all(),
        ];

        return view('auth.dashboard', compact('data'));
    }

    // Customer CRUD
    public function storeCustomer(Request $request)
    {
        try {
            Log::info('Customer store request:', $request->all());
            
            $request->validate([
                'Customer_Name' => 'required|string|max:255',
                'Email' => 'required|email|unique:customers,email',
                'Phone' => 'required|string|max:20',
            ]);

            $customer = Customer::create([
                'name' => $request->Customer_Name,
                'email' => $request->Email,
                'phone' => $request->Phone,
                'username' => $request->Email,
                'password' => bcrypt('default123'),
            ]);

            Log::info('Customer created:', $customer->toArray());
            return response()->json(['success' => true, 'message' => 'Customer created successfully']);
            
        } catch (Exception $e) {
            Log::error('Customer store error:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateCustomer(Request $request, $id)
    {
        try {
            Log::info('Customer update request:', ['id' => $id, 'data' => $request->all()]);
            
            $customer = Customer::findOrFail($id);
            
            $request->validate([
                'Customer_Name' => 'required|string|max:255',
                'Email' => 'required|email|unique:customers,email,' . $id,
                'Phone' => 'required|string|max:20',
            ]);

            $customer->update([
                'name' => $request->Customer_Name,
                'email' => $request->Email,
                'phone' => $request->Phone,
            ]);

            Log::info('Customer updated:', $customer->toArray());
            return response()->json(['success' => true, 'message' => 'Customer updated successfully']);
            
        } catch (Exception $e) {
            Log::error('Customer update error:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteCustomer($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();
            
            Log::info('Customer deleted:', ['id' => $id]);
            return response()->json(['success' => true, 'message' => 'Customer deleted successfully']);
            
        } catch (Exception $e) {
            Log::error('Customer delete error:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Customer Delivery CRUD
    public function storeCustomerDelivery(Request $request)
    {
        try {
            Log::info('Customer delivery store request:', $request->all());
            
            $request->validate([
                'Customer_Name' => 'required|string',
                'Address' => 'required|string',
                'City' => 'required|string',
                'Zip_Code' => 'required|string',
            ]);

            $customer = Customer::where('name', $request->Customer_Name)->first();
            if (!$customer) {
                return response()->json(['success' => false, 'message' => 'Customer not found'], 400);
            }

            $delivery = CustomerDelivery::create([
                'customer_id' => $customer->id,
                'address' => $request->Address,
                'city' => $request->City,
                'zip_code' => $request->Zip_Code,
            ]);

            Log::info('Customer delivery created:', $delivery->toArray());
            return response()->json(['success' => true, 'message' => 'Customer delivery created successfully']);
            
        } catch (Exception $e) {
            Log::error('Customer delivery store error:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateCustomerDelivery(Request $request, $id)
    {
        try {
            $delivery = CustomerDelivery::findOrFail($id);
            
            $request->validate([
                'Customer_Name' => 'required|string',
                'Address' => 'required|string',
                'City' => 'required|string',
                'Zip_Code' => 'required|string',
            ]);

            $customer = Customer::where('name', $request->Customer_Name)->first();
            if (!$customer) {
                return response()->json(['success' => false, 'message' => 'Customer not found'], 400);
            }

            $delivery->update([
                'customer_id' => $customer->id,
                'address' => $request->Address,
                'city' => $request->City,
                'zip_code' => $request->Zip_Code,
            ]);

            return response()->json(['success' => true, 'message' => 'Customer delivery updated successfully']);
            
        } catch (Exception $e) {
            Log::error('Customer delivery update error:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteCustomerDelivery($id)
    {
        try {
            CustomerDelivery::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Customer delivery deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Employee CRUD
    public function storeEmployee(Request $request)
    {
        try {
            Log::info('Employee store request:', $request->all());
            
            $request->validate([
                'Employee_Name' => 'required|string|max:255',
                'NIC' => 'required|string|unique:employees,nic',
                'Email' => 'required|email|unique:employees,email',
                'Contact' => 'required|string',
                'Role' => 'required|string',
                'Salary' => 'required|numeric',
            ]);

            $employee = Employee::create([
                'name' => $request->Employee_Name,
                'nic' => $request->NIC,
                'email' => $request->Email,
                'contact' => $request->Contact,
                'role' => $request->Role,
                'salary' => $request->Salary,
            ]);

            Log::info('Employee created:', $employee->toArray());
            return response()->json(['success' => true, 'message' => 'Employee created successfully']);
            
        } catch (Exception $e) {
            Log::error('Employee store error:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateEmployee(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            
            $request->validate([
                'Employee_Name' => 'required|string|max:255',
                'NIC' => 'required|string|unique:employees,nic,' . $id,
                'Email' => 'required|email|unique:employees,email,' . $id,
                'Contact' => 'required|string',
                'Role' => 'required|string',
                'Salary' => 'required|numeric',
            ]);

            $employee->update([
                'name' => $request->Employee_Name,
                'nic' => $request->NIC,
                'email' => $request->Email,
                'contact' => $request->Contact,
                'role' => $request->Role,
                'salary' => $request->Salary,
            ]);

            return response()->json(['success' => true, 'message' => 'Employee updated successfully']);
            
        } catch (Exception $e) {
            Log::error('Employee update error:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteEmployee($id)
    {
        try {
            Employee::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Employee deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Product CRUD
    public function storePart(Request $request)
    {
        try {
            Log::info('Part store request:', $request->all());
            
            $request->validate([
                'Part_Name' => 'required|string',
                'Part_Number' => 'required|string|unique:parts,part_number',
                'Brand' => 'required|string',
                'Model' => 'required|string',
                'Price' => 'required|numeric',
                'Description' => 'required|string',
                'Stock' => 'required|integer',
            ]);

            $part = Part::create([
                'part_name' => $request->Part_Name,
                'part_number' => $request->Part_Number,
                'brand' => $request->Brand,
                'model' => $request->Model,
                'price' => $request->Price,
                'description' => $request->Description,
                'stock' => $request->Stock,
            ]);

            Log::info('Product created:', $part->toArray());
            return response()->json(['success' => true, 'message' => 'Product created successfully']);
            
        } catch (Exception $e) {
            Log::error('Product store error:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updatePart(Request $request, $id)
    {
        try {
            $part = Part::findOrFail($id);
            
            $request->validate([
                'Part_Name' => 'required|string',
                'Part_Number' => 'required|string|unique:parts,part_number,' . $id,
                'Brand' => 'required|string',
                'Model' => 'required|string',
                'Price' => 'required|numeric',
                'Description' => 'required|string',
                'Stock' => 'required|integer',
            ]);

            $part->update([
                'part_name' => $request->Part_Name,
                'part_number' => $request->Part_Number,
                'brand' => $request->Brand,
                'model' => $request->Model,
                'price' => $request->Price,
                'description' => $request->Description,
                'stock' => $request->Stock,
            ]);

            return response()->json(['success' => true, 'message' => 'Product updated successfully']);
            
        } catch (Exception $e) {
            Log::error('Product update error:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deletePart($id)
    {
        try {
            Part::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Job CRUD
    public function storeJob(Request $request)
    {
        try {
            Log::info('Job store request:', $request->all());
            
            $request->validate([
                'Type' => 'required|string',
                'Customer' => 'required|string',
                'Date' => 'required|date',
                'Description' => 'required|string',
                'Price' => 'required|numeric',
                'Technician' => 'required|string',
            ]);

            $job = Job::create([
                'type' => $request->Type,
                'customer' => $request->Customer,
                'date' => $request->Date,
                'description' => $request->Description,
                'price' => $request->Price,
                'technician' => $request->Technician,
            ]);

            Log::info('Job created:', $job->toArray());
            return response()->json(['success' => true, 'message' => 'Job created successfully']);
            
        } catch (Exception $e) {
            Log::error('Job store error:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateJob(Request $request, $id)
    {
        try {
            $job = Job::findOrFail($id);
            
            $request->validate([
                'Type' => 'required|string',
                'Customer' => 'required|string',
                'Date' => 'required|date',
                'Description' => 'required|string',
                'Price' => 'required|numeric',
                'Technician' => 'required|string',
            ]);

            $job->update([
                'type' => $request->Type,
                'customer' => $request->Customer,
                'date' => $request->Date,
                'description' => $request->Description,
                'price' => $request->Price,
                'technician' => $request->Technician,
            ]);

            return response()->json(['success' => true, 'message' => 'Job updated successfully']);
            
        } catch (Exception $e) {
            Log::error('Job update error:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteJob($id)
    {
        try {
            Job::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Job deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}