<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\PartController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CustomerDeliveryController;
use App\Http\Controllers\Api\CustomerVehicleController;
use App\Http\Controllers\Api\VehicleRepairController;
use App\Http\Controllers\Api\VehicleServiceController;
use App\Http\Controllers\Api\RepairBookingController;
use App\Http\Controllers\Api\ServiceBookingController;
use App\Http\Controllers\Api\CustomerChatController;
use App\Models\Part;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('parts', PartController::class);
    Route::apiResource('tasks', JobController::class);
    Route::apiResource('orders', JobController::class);
    Route::apiResource('customer-deliveries', CustomerDeliveryController::class);
    Route::apiResource('customer-vehicles', CustomerVehicleController::class);
    Route::apiResource('vehicle-repairs', VehicleRepairController::class);
    Route::apiResource('vehicle-services', VehicleServiceController::class);
    Route::apiResource('repair-bookings', RepairBookingController::class);
    Route::apiResource('service-bookings', ServiceBookingController::class);
    Route::apiResource('customer-chats', CustomerChatController::class);
});

Route::get('/products/top5', function () {
    return Part::orderBy('price', 'desc')
        ->take(5)
        ->get(['partName', 'brand', 'model']);
});