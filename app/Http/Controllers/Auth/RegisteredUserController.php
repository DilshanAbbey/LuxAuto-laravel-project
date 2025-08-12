<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

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
            'username' => ['required', 'string', 'max:255', 'unique:customers,username', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email', 'unique:users,email'],
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

        // User record will be automatically created via Customer model's booted method
        // Find the created user and authenticate
        $user = User::where('user_type', 'customer')
                   ->where('original_id', $customer->id)
                   ->first();

        Auth::login($user);

        return redirect('/shop');
    }
}