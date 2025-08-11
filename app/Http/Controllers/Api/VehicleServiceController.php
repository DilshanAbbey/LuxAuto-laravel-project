<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleServiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->canAccessDashboard()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = VehicleService::with(['customer', 'vehicle']);
        
        // Technicians only see their services
        if ($user->isTechnician()) {
            $query->where('technician', $user->name);
        }

        $services = $query->get();
        return response()->json($services);
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
            'serviceDate' => 'required|date',
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

        $service = VehicleService::create([
            'idVehicle_Service' => 'REP' . str_pad(VehicleService::count() + 1, 4, '0', STR_PAD_LEFT),
            'customer_id' => $request->customer_id,
            'vehicle_id' => $request->vehicle_id,
            'serviceDate' => $request->serviceDate,
            'description' => $request->description,
            'price' => $request->price,
            'technician' => $request->technician
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service record created successfully',
            'data' => $service->load(['customer', 'vehicle'])
        ]);
    }

    public function update(Request $request, VehicleService $vehicleService)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:customer_vehicles,id',
            'serviceDate' => 'required|date',
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

        $vehicleService->update($request->only([
            'customer_id', 'vehicle_id', 'serviceDate', 
            'description', 'price', 'technician'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Service record updated successfully',
            'data' => $vehicleService->load(['customer', 'vehicle'])
        ]);
    }

    public function destroy(VehicleService $vehicleService)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $vehicleService->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service record deleted successfully'
        ]);
    }
}