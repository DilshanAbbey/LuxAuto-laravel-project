<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Login/Register page (only if you're using a custom one)
Route::get('/loginregister', function () {
    return view('loginregister');
});

// Shop page
Route::get('/shop', function () {
    return view('shop');
});

// Dashboard page
Route::get('/dashboard', function () {
    return view('auth.dashboard');
});

// Abput Us page
Route::get('/aboutus', function () {
    return view('aboutus');
});

// Contact Us page
Route::get('/contactus', function () {
    return view('contactus');
});

use App\Http\Controllers\CustomerController;

Route::resource('customers', CustomerController::class);