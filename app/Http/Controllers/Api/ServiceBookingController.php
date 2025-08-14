<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceBookingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->canAccessDashboard()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = ServiceBooking::with('customer');
        
        if ($user->isTechnician()) {
            $query->where('technician', $user->name);
        }

        $bookings = $query->get();
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:customer_vehicles,id',
            'slotNumber' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'technician' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $booking = ServiceBooking::create([
            'idService_booking' => 'SB' . str_pad(ServiceBooking::count() + 1, 4, '0', STR_PAD_LEFT),
            'customer_id' => $request->customer_id,
            'vehicle_id' => $request->vehicle_id,
            'slotNumber' => $request->slotNumber,
            'date' => $request->date,
            'time' => $request->time,
            'technician' => $request->technician
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service booking created successfully',
            'data' => $booking->load('customer')
        ]);
    }

    public function update(Request $request, ServiceBooking $serviceBooking)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:customer_vehicles,id',
            'slotNumber' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'technician' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $serviceBooking->update($request->only([
            'customer_id', 'vehicle_id', 'slotNumber', 
            'date', 'time', 'technician'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Service booking updated successfully',
            'data' => $serviceBooking->load('customer')
        ]);
    }

    public function destroy(ServiceBooking $serviceBooking)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $serviceBooking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service booking deleted successfully'
        ]);
    }
}