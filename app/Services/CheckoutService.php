<?php

namespace App\Services;

use App\Models\Crud;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Str;

class CheckoutService
{
    public function handlePaymentConfirmation($request, $cart)
    {
        $orderNumber = 'ORD-' . strtoupper(Str::random(10));
        $transaction = null;

        // Variables for order creation, initialized with defaults
        $orderStatus = 'pending';
        $paymentStatus = 'pending';
        $paymentGateway = $request->payment_method;
        $shippingAddress = json_encode($request->shipping ?? []);
        $billingAddress = json_encode($request->billing ?? null);
        $totalAmount = $cart['total'];
        $totalAmount = (float)str_replace(',', '', $totalAmount);
        $currency = 'usd';

        // Handle payment-specific logic
        if ($request->payment_method === 'stripe') {
            $transaction = Transaction::where('transaction_id', $request->transaction_id)
                ->where('status', 'pending')
                ->firstOrFail();

            $meta = json_decode($transaction->meta, true);

            // Update variables for Stripe
            $orderStatus = 'processing';
            $paymentStatus = 'paid';
            $shippingAddress = json_encode($meta['shipping'] ?? []);
            $billingAddress = json_encode($meta['billing'] ?? null);
            $currency = $transaction->currency;
        } else if ($request->payment_method === 'cod') {
            // Create a transaction for COD
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'type' => 'payment',
                'transaction_id' => $request->transaction_id,
                'amount' => $totalAmount,
                'currency' => $currency,
                'status' => 'pending',
                'gateway' => 'cod',
                'meta' => json_encode(['shipping' => $request->shipping, 'total' => $totalAmount]),
            ]);
        } else {
            return response()->json(['error' => 'Invalid payment method.'], 400);
        }

        // Create the order using the determined variables
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => $orderNumber,
            'status' => $orderStatus,
            'payment_status' => $paymentStatus,
            'subtotal' => $cart['subtotal'] ?? $totalAmount,
            'total' => $totalAmount,
            'currency' => $currency,
            'payment_gateway' => $paymentGateway,
            'shipping_address' => $shippingAddress,
            'billing_address' => $billingAddress,
            'discount' => $cart['discount'] ?? 0,
            'tax' => $cart['tax'] ?? 0,
            'shipping_cost' => $cart['shipping_cost'] ?? 0,
        ]);

        // If a transaction was created/found, update it with the order ID
        if ($transaction) {
            $transaction->update(['order_id' => $order->id]);
        }

        // Create order items (common logic for all payment methods)
        foreach ($cart['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'],
                'name' => $item['title'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
                'meta' => json_encode($item['meta'] ?? null),
            ]);
        }
    }

    public function createTransactionFromStripeCharge($charge){
        return Transaction::create([
                'user_id' => auth()->id(),
                'type' => 'payment',
                'transaction_id' => $charge['transaction_id'] ?? null,
                'amount' => $charge['amount'],
                'currency' => $charge['currency'],
                'status' => 'pending',
                'gateway' => 'stripe',
                'meta' => json_encode($charge['meta'] ?? []),
            ]);
    }
}
