<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerDelivery;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerAddressController extends Controller
{
    // Get all addresses for the authenticated customer
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->isCustomer()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $customer = Customer::where('id', $user->original_id)->first();
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $addresses = CustomerDelivery::where('customer_id', $customer->id)->get();
        return response()->json($addresses);
    }

    // Create new address
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->isCustomer()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $customer = Customer::where('id', $user->original_id)->first();
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $validator = Validator::make($request->all(), [
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

        $delivery = CustomerDelivery::create([
            'customer_id' => $customer->id,
            'address' => $request->address,
            'city' => $request->city,
            'zip_code' => $request->zip_code
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully',
            'data' => $delivery
        ]);
    }

    // Update address
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        
        if (!$user->isCustomer()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $customer = Customer::where('id', $user->original_id)->first();
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $delivery = CustomerDelivery::where('id', $id)
                                  ->where('customer_id', $customer->id)
                                  ->first();

        if (!$delivery) {
            return response()->json(['error' => 'Address not found'], 404);
        }

        $validator = Validator::make($request->all(), [
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

        $delivery->update([
            'address' => $request->address,
            'city' => $request->city,
            'zip_code' => $request->zip_code
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully',
            'data' => $delivery
        ]);
    }

    // Delete address
    public function destroy($id)
    {
        $user = auth()->user();
        
        if (!$user->isCustomer()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $customer = Customer::where('id', $user->original_id)->first();
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $delivery = CustomerDelivery::where('id', $id)
                                  ->where('customer_id', $customer->id)
                                  ->first();

        if (!$delivery) {
            return response()->json(['error' => 'Address not found'], 404);
        }

        $delivery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully'
        ]);
    }
}