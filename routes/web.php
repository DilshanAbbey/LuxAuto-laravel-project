<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Include auth routes
require __DIR__.'/auth.php';

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/aboutus', function () {
    return view('aboutus');
});

Route::get('/contactus', function () {
    return view('contactus');
});

// Protected routes
Route::middleware('auth')->group(function () {
    // Shop - only for customers
    Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])
        ->middleware('role:customer')
        ->name('shop');

    Route::get('/api/products', [App\Http\Controllers\ShopController::class, 'getProducts'])
        ->middleware('role:customer');

    // Dashboard - only for non-customers
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:administrator,employee,technician')
        ->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard API routes
Route::middleware(['auth', 'role:administrator,employee,technician'])->prefix('dashboard')->group(function () {
    Route::apiResource('customers', App\Http\Controllers\Api\CustomerController::class);
    Route::apiResource('employees', App\Http\Controllers\Api\EmployeeController::class);
    Route::apiResource('parts', App\Http\Controllers\Api\PartController::class);
    Route::apiResource('tasks', App\Http\Controllers\Api\JobController::class);
    Route::apiResource('customer-deliveries', App\Http\Controllers\Api\CustomerDeliveryController::class);
    Route::apiResource('customer-vehicles', App\Http\Controllers\Api\CustomerVehicleController::class);
    Route::apiResource('vehicle-repairs', App\Http\Controllers\Api\VehicleRepairController::class);
    Route::apiResource('vehicle-services', App\Http\Controllers\Api\VehicleServiceController::class);
    Route::apiResource('repair-bookings', App\Http\Controllers\Api\RepairBookingController::class);
    Route::apiResource('service-bookings', App\Http\Controllers\Api\ServiceBookingController::class);
    Route::apiResource('customer-chats', App\Http\Controllers\Api\CustomerChatController::class);
    Route::apiResource('orders', App\Http\Controllers\Api\OrderController::class)->only(['index', 'show', 'update']);
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    // Cart routes
    Route::get('/api/cart', [App\Http\Controllers\CartController::class, 'index']);
    Route::post('/api/cart', [App\Http\Controllers\CartController::class, 'store']);
    Route::put('/api/cart/{cart}', [App\Http\Controllers\CartController::class, 'update']);
    Route::delete('/api/cart/{cart}', [App\Http\Controllers\CartController::class, 'destroy']);
    
    // User profile routes
    Route::get('/api/products', [App\Http\Controllers\ShopController::class, 'getProducts']);
    Route::get('/api/user', [App\Http\Controllers\Api\UserProfileController::class, 'show']);
    Route::put('/api/user', [App\Http\Controllers\Api\UserProfileController::class, 'update']);
    
    // Payment routes
    Route::post('/api/payment/intent', [App\Http\Controllers\PaymentController::class, 'createPaymentIntent']);
    Route::post('/api/payment/confirm', [App\Http\Controllers\PaymentController::class, 'confirmPayment']);

    // Order routes
    Route::get('/api/orders', [App\Http\Controllers\Api\OrderController::class, 'index']);
    Route::get('/api/orders/{order}', [App\Http\Controllers\Api\OrderController::class, 'show']);
});
