Route::middleware(['api'])->group(function () {
    // Order routes
    Route::post('/api/orders', [OrderController::class, 'store']);
    Route::get('/api/orders', [OrderController::class, 'index']);
    Route::get('/api/orders/{orderId}', [OrderController::class, 'show']);
    Route::put('/api/orders/{orderId}/payment-status', [OrderController::class, 'updatePaymentStatus']);
    
    // Payment routes
    Route::post('/api/payment/stripe/create', [PaymentController::class, 'createStripePayment']);
    Route::post('/api/payment/razorpay/create', [PaymentController::class, 'createRazorpayPayment']);
});