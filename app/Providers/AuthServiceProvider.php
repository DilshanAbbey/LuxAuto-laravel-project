<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
//use Illuminate\Support\Facades\Auth;
//use App\Providers\CustomUserProvider;
use App\Models\Cart;
use App\Policies\CartPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Cart::class => CartPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        /*Auth::provider('custom', function ($app, array $config) {
            return new CustomUserProvider();
        });*/
    }
}