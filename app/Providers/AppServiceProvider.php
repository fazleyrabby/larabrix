<?php

namespace App\Providers;

use App\Contracts\PaymentGatewayInterface;
use App\Models\PaymentGateway;
use App\PaymentGateway\Stripe;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('admin.components.modal', 'modal');
        Blade::component('frontend.partials.sidebar', 'sidebar');
    }
}
