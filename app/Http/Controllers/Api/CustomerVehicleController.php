<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerVehicle;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerVehicleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->canAccessDashboard()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $vehicles = CustomerVehicle::with('customer')->get();
        return response()->json($vehicles);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'vehicleNumber' => 'required|string|unique:customer_vehicles,vehicleNumber',
            'vehicleBrand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'trim_edition' => 'nullable|string|max:255',
            'modalYear' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $vehicle = CustomerVehicle::create([
            'idCustomer_Vehicle' => 'VEH' . str_pad(CustomerVehicle::count() + 1, 4, '0', STR_PAD_LEFT),
            'customer_id' => $request->customer_id,
            'vehicleNumber' => $request->vehicleNumber,
            'vehicleBrand' => $request->vehicleBrand,
            'model' => $request->model,
            'trim_edition' => $request->trim_edition,
            'modalYear' => $request->modalYear,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle created successfully',
            'data' => $vehicle->load('customer')
        ]);
    }

    public function update(Request $request, CustomerVehicle $customerVehicle)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'vehicleNumber' => 'required|string|unique:customer_vehicles,vehicleNumber,' . $customerVehicle->id,
            'vehicleBrand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'trim_edition' => 'nullable|string|max:255',
            'modalYear' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $customerVehicle->update($request->only([
            'customer_id', 'vehicleNumber', 'vehicleBrand', 'model', 
            'trim_edition', 'modalYear', 'description'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Vehicle updated successfully',
            'data' => $customerVehicle->load('customer')
        ]);
    }

    public function destroy(CustomerVehicle $customerVehicle)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $customerVehicle->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle deleted successfully'
        ]);
    }
}