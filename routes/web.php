<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/aboutus', function () {
    return view('aboutus');
});

Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])
    ->middleware(['auth', 'role:customer'])
    ->name('shop');

Route::get('/api/products', [App\Http\Controllers\ShopController::class, 'getProducts'])
    ->middleware(['auth', 'role:customer']);

Route::get('/contactus', function () {
    return view('contactus');
});

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard - only for non-customers
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:administrator,employee,technician')
        ->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Custom auth routes - handle login and register on same page
Route::middleware('guest')->group(function () {
    Route::get('/loginregister', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/loginregister', [AuthenticatedSessionController::class, 'store'])->name('login.post');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
});

// Logout route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/auth.php';

// Dashboard API routes (using web middleware for CSRF)
Route::middleware(['auth', 'role:administrator,employee,technician'])->prefix('dashboard')->group(function () {
    Route::apiResource('customers', App\Http\Controllers\Api\CustomerController::class);
    Route::apiResource('employees', App\Http\Controllers\Api\EmployeeController::class);
    Route::apiResource('parts', App\Http\Controllers\Api\PartController::class);
    Route::apiResource('jobs', App\Http\Controllers\Api\JobController::class);
    Route::apiResource('customer-deliveries', App\Http\Controllers\Api\CustomerDeliveryController::class);
    Route::apiResource('customer-vehicles', App\Http\Controllers\Api\CustomerVehicleController::class);
    Route::apiResource('vehicle-repairs', App\Http\Controllers\Api\VehicleRepairController::class);
    Route::apiResource('vehicle-services', App\Http\Controllers\Api\VehicleServiceController::class);
    Route::apiResource('repair-bookings', App\Http\Controllers\Api\RepairBookingController::class);
    Route::apiResource('service-bookings', App\Http\Controllers\Api\ServiceBookingController::class);
    Route::apiResource('customer-chats', App\Http\Controllers\Api\CustomerChatController::class);
});
