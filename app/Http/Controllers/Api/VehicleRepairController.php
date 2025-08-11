<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleRepair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleRepairController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->canAccessDashboard()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = VehicleRepair::with(['customer', 'vehicle']);
        
        // Technicians only see their repairs
        if ($user->isTechnician()) {
            $query->where('technician', $user->name);
        }

        $repairs = $query->get();
        return response()->json($repairs);
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
            'repairDate' => 'required|date',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'technician' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $repair = VehicleRepair::create([
            'idVehicle_Repair' => 'REP' . str_pad(VehicleRepair::count() + 1, 4, '0', STR_PAD_LEFT),
            'customer_id' => $request->customer_id,
            'vehicle_id' => $request->vehicle_id,
            'repairDate' => $request->repairDate,
            'description' => $request->description,
            'price' => $request->price,
            'technician' => $request->technician
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Repair record created successfully',
            'data' => $repair->load(['customer', 'vehicle'])
        ]);
    }

    public function update(Request $request, VehicleRepair $vehicleRepair)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:customer_vehicles,id',
            'repairDate' => 'required|date',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'technician' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $vehicleRepair->update($request->only([
            'customer_id', 'vehicle_id', 'repairDate', 
            'description', 'price', 'technician'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Repair record updated successfully',
            'data' => $vehicleRepair->load(['customer', 'vehicle'])
        ]);
    }

    public function destroy(VehicleRepair $vehicleRepair)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $vehicleRepair->delete();

        return response()->json([
            'success' => true,
            'message' => 'Repair record deleted successfully'
        ]);
    }
}