<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Customer routes
Route::post('/dashboard/customers', [DashboardController::class, 'storeCustomer'])->name('customers.store');
Route::put('/dashboard/customers/{id}', [DashboardController::class, 'updateCustomer'])->name('customers.update');
Route::delete('/dashboard/customers/{id}', [DashboardController::class, 'deleteCustomer'])->name('customers.delete');

// Customer Delivery routes
Route::post('/dashboard/customer-deliveries', [DashboardController::class, 'storeCustomerDelivery'])->name('customer-deliveries.store');
Route::put('/dashboard/customer-deliveries/{id}', [DashboardController::class, 'updateCustomerDelivery'])->name('customer-deliveries.update');
Route::delete('/dashboard/customer-deliveries/{id}', [DashboardController::class, 'deleteCustomerDelivery'])->name('customer-deliveries.delete');

// Customer Vehicle routes
Route::post('/dashboard/customer-vehicles', [DashboardController::class, 'storeCustomerVehicle'])->name('customer-vehicles.store');
Route::put('/dashboard/customer-vehicles/{id}', [DashboardController::class, 'updateCustomerVehicle'])->name('customer-vehicles.update');
Route::delete('/dashboard/customer-vehicles/{id}', [DashboardController::class, 'deleteCustomerVehicle'])->name('customer-vehicles.delete');

// Vehicle Repair routes
Route::post('/dashboard/vehicle-repairs', [DashboardController::class, 'storeVehicleRepair'])->name('vehicle-repairs.store');
Route::put('/dashboard/vehicle-repairs/{id}', [DashboardController::class, 'updateVehicleRepair'])->name('vehicle-repairs.update');
Route::delete('/dashboard/vehicle-repairs/{id}', [DashboardController::class, 'deleteVehicleRepair'])->name('vehicle-repairs.delete');

// Employee routes
Route::post('/dashboard/employees', [DashboardController::class, 'storeEmployee'])->name('employees.store');
Route::put('/dashboard/employees/{id}', [DashboardController::class, 'updateEmployee'])->name('employees.update');
Route::delete('/dashboard/employees/{id}', [DashboardController::class, 'deleteEmployee'])->name('employees.delete');

// Product routes
Route::post('/dashboard/products', [DashboardController::class, 'storeProduct'])->name('products.store');
Route::put('/dashboard/products/{id}', [DashboardController::class, 'updateProduct'])->name('products.update');
Route::delete('/dashboard/products/{id}', [DashboardController::class, 'deleteProduct'])->name('products.delete');

// Job routes
Route::post('/dashboard/jobs', [DashboardController::class, 'storeJob'])->name('jobs.store');
Route::put('/dashboard/jobs/{id}', [DashboardController::class, 'updateJob'])->name('jobs.update');
Route::delete('/dashboard/jobs/{id}', [DashboardController::class, 'deleteJob'])->name('jobs.delete');