<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Providers\CustomUserProvider;

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';

    /**
     * Register any application services.
     */
    
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the custom user provider
        Auth::provider('custom', function ($app, array $config) {
            return new CustomUserProvider();
        });
    }
}
