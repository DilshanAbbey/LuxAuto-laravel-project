<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $customer = $user->customerProfile;
        
        return response()->json([
            'name' => $customer->customerName ?? $user->name,
            'email' => $customer->email ?? $user->email,
            'phone' => $customer->contactNumber ?? $user->phone,
            'type' => 'Customer',
            'username' => $customer->username ?? $user->username
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'customerName' => 'required|string|max:255',
            'email' => 'required|email',
            'contactNumber' => 'required|string|max:20'
        ]);

        $user = auth()->user();
        $customer = $user->customerProfile;

        if ($customer) {
            $customer->update([
                'customerName' => $request->customerName,
                'email' => $request->email,
                'contactNumber' => $request->contactNumber
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully'
        ]);
    }
}