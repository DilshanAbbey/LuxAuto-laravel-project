<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\User;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.loginregister');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:customers,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create customer record
        $customer = Customer::create([
            'idCustomer' => 'CUST' . str_pad(Customer::count() + 1, 4, '0', STR_PAD_LEFT),
            'customerName' => $request->first_name . ' ' . $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'contactNumber' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Create User object for authentication
        $user = new User([
            'id' => 'customer_' . $customer->id,
            'name' => $customer->customerName,
            'username' => $customer->username,
            'email' => $customer->email,
            'phone' => $customer->contactNumber,
            'password' => $customer->password,
            'role' => 'customer',
            'user_type' => 'customer',
            'original_id' => $customer->id,
        ]);

        Auth::login($user);

        return redirect('/shop');
    }
}
