<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Part;
use App\Models\Task;
use App\Models\Order;
use App\Models\CustomerDelivery;
use App\Models\CustomerVehicle;
use App\Models\VehicleRepair;
use App\Models\VehicleService;
use App\Models\RepairBooking;
use App\Models\ServiceBooking;
use App\Models\CustomerChat;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Base data that all dashboard users can see
        $data = [
            'customers' => collect(),
            'employees' => collect(),
            'parts' => collect(),
            'jobs' => collect(),
            'orders' => collect(),
            'customerDeliveries' => collect(),
            'customerVehicles' => collect(),
            'vehicleRepairs' => collect(),
            'vehicleServices' => collect(),
            'repairBooking' => collect(),
            'serviceBooking' => collect(),
            'customerChats' => collect(),
            'orderItems' => collect(),
        ];

        if ($user->isAdministrator()) {
            // Administrators can see everything
            $data = [
                'customers' => Customer::all(),
                'employees' => Employee::all(),
                'parts' => Part::all(),
                'jobs' => Task::all(), // Changed from Job to Task
                'orders' => Order::with('user')->get(), // Add orders
                'customerDeliveries' => CustomerDelivery::with('customer')->get(),
                'customerVehicles' => CustomerVehicle::with('customer')->get(),
                'vehicleRepairs' => VehicleRepair::with(['customer', 'vehicle'])->get(),
                'vehicleServices' => VehicleService::with(['customer', 'vehicle'])->get(),
                'repairBooking' => RepairBooking::with('customer')->get(),
                'serviceBooking' => ServiceBooking::with('customer')->get(),
                'customerChats' => CustomerChat::with(['customer', 'employee'])->get(),
                'orderItems' => OrderItem::with(['order.user', 'part'])->get(),
            ];
        } elseif ($user->isEmployee()) {
            // Employees can see parts, bookings, vehicles, repairs/services, jobs
            $data = [
                'customers' => collect(),
                'employees' => collect(),
                'parts' => Part::all(),
                'jobs' => Task::all(), // Changed from Job to Task
                'orders' => Order::with('user')->get(), // Add orders
                'customerDeliveries' => collect(),
                'customerVehicles' => CustomerVehicle::with('customer')->get(),
                'vehicleRepairs' => VehicleRepair::with(['customer', 'vehicle'])->get(),
                'vehicleServices' => VehicleService::with(['customer', 'vehicle'])->get(),
                'repairBooking' => RepairBooking::with('customer')->get(),
                'serviceBooking' => ServiceBooking::with('customer')->get(),
                'customerChats' => collect(),
                'orderItems' => OrderItem::with(['order.user', 'part'])->get(),
            ];
        } elseif ($user->isTechnician()) {
            // Technicians can only see their assigned jobs and job history
            $technicianName = $user->name;
            
            // Combine repair and service bookings as "jobs" for technicians
            $repairJobs = RepairBooking::where('technician', $technicianName)
                ->with(['customer', 'vehicle'])
                ->get()
                ->map(function($booking) {
                    return (object)[
                        'id' => $booking->id,
                        'type' => 'Repair',
                        'customer' => optional($booking->customer)->customerName ?? 'N/A',
                        'date' => $booking->date,
                        'time' => $booking->time ?? '00:00:00',
                        'description' => 'Vehicle Repair Booking - Slot ' . $booking->slotNumber,
                        'technician' => $booking->technician_in_charge
                    ];
                });
            
            $serviceJobs = ServiceBooking::where('technician', $technicianName)
                ->with(['customer', 'vehicle'])
                ->get()
                ->map(function($booking) {
                    return (object)[
                        'id' => $booking->id,
                        'type' => 'Service',
                        'customer' => optional($booking->customer)->customerName ?? 'N/A',
                        'date' => $booking->date,
                        'time' => $booking->time ?? '00:00:00',
                        'description' => 'Vehicle Service Booking - Slot ' . $booking->slotNumber,
                        'technician' => $booking->technician
                    ];
                });
            
            $combinedJobs = $repairJobs->concat($serviceJobs);
            
            $data = [
                'customers' => collect(),
                'employees' => collect(),
                'parts' => collect(),
                'jobs' => $combinedJobs,
                'orders' => collect(),
                'customerDeliveries' => collect(),
                'customerVehicles' => collect(),
                'vehicleRepairs' => VehicleRepair::where('technician', $technicianName)->with(['customer', 'vehicle'])->get(),
                'vehicleServices' => VehicleService::where('technician', $technicianName)->with(['customer', 'vehicle'])->get(),
                'repairBooking' => collect(),
                'serviceBooking' => collect(),
                'customerChats' => collect(),
                'orderItems' => collect(),
            ];
        }
        

        return view('auth.dashboard', compact('data'));
    }
}