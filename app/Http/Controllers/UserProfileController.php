<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Get customer profile if user is a customer
        if ($user->isCustomer()) {
            $customer = Customer::where('id', $user->original_id)->first();
            
            if ($customer) {
                return response()->json([
                    'name' => $customer->customerName,
                    'email' => $customer->email,
                    'phone' => $customer->contactNumber,
                    'username' => $customer->username,
                    'password' > $customer->password,
                    'type' => 'Customer'
                ]);
            }
        }
        
        // Fallback to user data
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'username' => $user->username,
            'type' => ucfirst($user->role)
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'customerName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contactNumber' => 'required|string|max:20'
        ]);

        $user = Auth::user();
        
        if ($user->isCustomer()) {
            $customer = Customer::where('id', $user->original_id)->first();
            
            if ($customer) {
                // Check if email is unique (excluding current customer)
                $existingCustomer = Customer::where('email', $request->email)
                                         ->where('id', '!=', $customer->id)
                                         ->first();
                
                if ($existingCustomer) {
                    return response()->json(['error' => 'Email already exists'], 422);
                }

                $customer->update([
                    'customerName' => $request->customerName,
                    'email' => $request->email,
                    'contactNumber' => $request->contactNumber
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Profile updated successfully'
                ]);
            }
        }

        return response()->json(['error' => 'Profile not found'], 404);
    }
}