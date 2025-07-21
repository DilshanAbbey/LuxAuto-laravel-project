<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

public function index() {
    $customers = Customer::all();
    return view('dashboard', compact('customers'));
}

class CustomerController extends Controller
{
    //
}
