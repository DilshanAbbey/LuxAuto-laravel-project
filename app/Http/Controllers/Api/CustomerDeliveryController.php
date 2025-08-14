<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerDelivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerDeliveryController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $deliveries = CustomerDelivery::with('customer')->get();
        return response()->json($deliveries);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $delivery = CustomerDelivery::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Customer delivery created successfully',
            'data' => $delivery->load('customer')
        ]);
    }

    public function update(Request $request, CustomerDelivery $customerDelivery)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $customerDelivery->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Customer delivery updated successfully',
            'data' => $customerDelivery->load('customer')
        ]);
    }

    public function destroy(CustomerDelivery $customerDelivery)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $customerDelivery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer delivery deleted successfully'
        ]);
    }
}