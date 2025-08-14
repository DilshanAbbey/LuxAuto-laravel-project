<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RepairBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RepairBookingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->canAccessDashboard()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = RepairBooking::with('customer');
        
        if ($user->isTechnician()) {
            $query->where('technician_in_charge', $user->name);
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
            'technician_in_charge' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $booking = RepairBooking::create([
            'idRepair_booking' => 'RB' . str_pad(RepairBooking::count() + 1, 4, '0', STR_PAD_LEFT),
            'customer_id' => $request->customer_id,
            'vehicle_id' => $request->vehicle_id,
            'slotNumber' => $request->slotNumber,
            'date' => $request->date,
            'time' => $request->time,
            'technician_in_charge' => $request->technician_in_charge
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Repair booking created successfully',
            'data' => $booking->load('customer')
        ]);
    }

    public function update(Request $request, RepairBooking $repairBooking)
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
            'technician_in_charge' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $repairBooking->update($request->only([
            'customer_id', 'vehicle_id', 'slotNumber', 
            'date', 'time', 'technician_in_charge'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Repair booking updated successfully',
            'data' => $repairBooking->load('customer')
        ]);
    }

    public function destroy(RepairBooking $repairBooking)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $repairBooking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Repair booking deleted successfully'
        ]);
    }
}