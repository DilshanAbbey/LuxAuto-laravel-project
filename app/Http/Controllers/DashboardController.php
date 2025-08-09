<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Part;
use App\Models\Job;
use App\Models\CustomerDelivery;
use App\Models\CustomerVehicle;
use App\Models\VehicleRepair;
use App\Models\VehicleService;
use App\Models\RepairBooking;
use App\Models\ServiceBooking;
use App\Models\CustomerChat;
use Illuminate\Support\Facades\Log;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Base data that all dashboard users can see
        $data = [];

        if ($user->isAdministrator()) {
            // Administrators can see everything
            $data = [
                'customers' => Customer::all(),
                'employees' => Employee::all(),
                'parts' => Part::all(),
                'jobs' => Job::all(),
                'customerDeliveries' => CustomerDelivery::with('customer')->get(),
                'customerVehicles' => CustomerVehicle::with('customer')->get(),
                'vehicleRepairs' => VehicleRepair::with(['customer', 'vehicle'])->get(),
                'vehicleServices' => VehicleService::with(['customer', 'vehicle'])->get(),
                'repairBooking' => RepairBooking::with('customer')->get(),
                'serviceBooking' => ServiceBooking::with('customer')->get(),
                'customerChats' => CustomerChat::with(['customer', 'employee'])->get(),
            ];
        } elseif ($user->isEmployee()) {
            // Employees can see parts, bookings, vehicles, repairs/services, jobs
            $data = [
                'customers' => collect(), // Empty collection
                'employees' => collect(),
                'parts' => Part::all(),
                'jobs' => Job::all(),
                'customerDeliveries' => collect(),
                'customerVehicles' => CustomerVehicle::with('customer')->get(),
                'vehicleRepairs' => VehicleRepair::with(['customer', 'vehicle'])->get(),
                'vehicleServices' => VehicleService::with(['customer', 'vehicle'])->get(),
                'repairBooking' => RepairBooking::with('customer')->get(),
                'serviceBooking' => ServiceBooking::with('customer')->get(),
                'customerChats' => collect(),
            ];
        } elseif ($user->isTechnician()) {
            // Technicians can only see their assigned jobs and job history
            $technicianName = $user->name; // Assuming technician name matches user name
            
            $data = [
                'customers' => collect(),
                'employees' => collect(),
                'parts' => collect(),
                'jobs' => Job::where('technician', $technicianName)->get(),
                'customerDeliveries' => collect(),
                'customerVehicles' => collect(),
                'vehicleRepairs' => VehicleRepair::where('technician', $technicianName)->with(['customer', 'vehicle'])->get(),
                'vehicleServices' => VehicleService::where('technician', $technicianName)->with(['customer', 'vehicle'])->get(),
                'repairBooking' => RepairBooking::where('technician_in_charge', $technicianName)->with('customer')->get(),
                'serviceBooking' => ServiceBooking::where('technician', $technicianName)->with('customer')->get(),
                'customerChats' => collect(),
            ];
        }

        return view('auth.dashboard', compact('data'));
    }
}