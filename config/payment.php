<?php
return [
    'stripe' => [
        'public_key' => env('STRIPE_KEY'),
        'secret_key' => env('STRIPE_SECRET'),
    ],
    'razorpay' => [
        'key_id' => env('RAZORPAY_KEY'),
        'key_secret' => env('RAZORPAY_SECRET'),
    ],
];