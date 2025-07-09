<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Login/Register page (only if you're using a custom one)
Route::get('/loginregister', function () {
    return view('auth.loginregister');
});

// Shop page
Route::get('/shop', function () {
    return view('shop');
});

// Dashboard page
Route::get('/dashboard', function () {
    return view('dashboard');
});

// Abput Us page
Route::get('/aboutus', function () {
    return view('aboutus');
});

// Abput Us page
Route::get('/contactus', function () {
    return view('contactus');
});

