<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $customers = Customer::all();
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customerName' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'contactNumber' => 'required|string|max:20',
            'username' => 'required|string|unique:customers,username',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Customer::create([
            'idCustomer' => 'CUST' . str_pad(Customer::count() + 1, 4, '0', STR_PAD_LEFT),
            'customerName' => $request->customerName,
            'email' => $request->email,
            'contactNumber' => $request->contactNumber,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer created successfully',
            'data' => $customer
        ]);
    }

    public function show(Customer $customer)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($customer);
    }

    public function update(Request $request, Customer $customer)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customerName' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'contactNumber' => 'required|string|max:20',
            'username' => 'required|string|unique:customers,username,' . $customer->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer->update($request->only([
            'customerName', 'email', 'contactNumber', 'username'
        ]));

        if ($request->password) {
            $customer->password = bcrypt($request->password);
            $customer->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully',
            'data' => $customer
        ]);
    }

    public function destroy(Customer $customer)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully'
        ]);
    }
}
