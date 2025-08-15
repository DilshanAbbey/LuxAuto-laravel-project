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

//Public routes (no middleware)
Route::get('/products/top5', function () {
    return Part::orderBy('price', 'desc')
        ->take(5)
        ->get(['id', 'partName', 'brand', 'model', 'price']);
});

Route::get('/parts/search/{partNumber}', function ($partNumber) {
    $part = \App\Models\Part::where('partNumber', 'LIKE', '%' . $partNumber . '%')->first();
    if ($part) {
        return response()->json([
            'found' => true,
            'partName' => $part->partName,
            'brand' => $part->brand,
            'model' => $part->model
        ]);
    }
    return response()->json(['found' => false]);
});

Route::post('/api/customer-chat/store', function (Request $request) {
    if (!auth()->check()) {
        return response()->json(['error' => 'Please login first'], 401);
    }
    
    if (!auth()->user()->isCustomer()) {
        return response()->json(['error' => 'Only customers can send messages'], 403);
    }
    
    $request->validate([
        'message' => 'required|string'
    ]);
    
    $customerChat = \App\Models\CustomerChat::create([
        'customer_id' => auth()->user()->original_id,
        'employee_id' => null,
        'date' => now()->format('Y-m-d'),
        'description' => $request->message,
        'status' => 'not resolved'
    ]);
    
    return response()->json(['success' => true, 'message' => 'Message sent successfully']);
});

Route::get('/api/user', function() {
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    return response()->json(['user' => auth()->user()]);
})->name('api.user');

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
    Route::apiResource('order-items', App\Http\Controllers\Api\OrderItemController::class);
    Route::get('orders/{orderId}/items', [App\Http\Controllers\Api\OrderItemController::class, 'getByOrder']);
});

Route::get('/api/parts/search/{partNumber}', function ($partNumber) {
    $part = Part::where('partNumber', 'LIKE', '%' . $partNumber . '%')->first();
    if ($part) {
        return response()->json([
            'found' => true,
            'partName' => $part->partName,
            'brand' => $part->brand,
            'model' => $part->model
        ]);
    }
    return response()->json(['found' => false]);
});
