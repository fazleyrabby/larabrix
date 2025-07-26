<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    public function run()
    {
        PaymentGateway::updateOrCreate([
            'slug' => 'stripe'
        ], [
            'name' => 'Stripe',
            'namespace' => 'App\\PaymentGateway\\Stripe',
            'config' => [
                'public_key' => env('STRIPE_PUBLIC_KEY', 'pk_test_xxxx'),
                'secret_key' => env('STRIPE_SECRET_KEY', 'sk_test_xxxx'),
                'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', 'whsec_xxxx'),
            ],
            'enabled' => true
        ]);

        PaymentGateway::updateOrCreate([
            'slug' => 'paypal'
        ], [
            'name' => 'PayPal',
            'namespace' => 'App\\PaymentGateway\\PayPal',
            'config' => [
                'client_id' => env('PAYPAL_CLIENT_ID', 'your-paypal-client-id'),
                'client_secret' => env('PAYPAL_CLIENT_SECRET', 'your-paypal-secret'),
                'mode' => env('PAYPAL_MODE', 'sandbox'), // sandbox or live
            ],
            'enabled' => true
        ]);

        PaymentGateway::updateOrCreate([
            'slug' => 'razorpay'
        ], [
            'name' => 'Razorpay',
            'namespace' => 'App\\PaymentGateway\\Razorpay',
            'config' => [
                'key_id' => env('RAZORPAY_KEY_ID', 'rzp_test_xxxx'),
                'key_secret' => env('RAZORPAY_KEY_SECRET', 'rzp_secret_xxxx'),
            ],
            'enabled' => true
        ]);
    }
}