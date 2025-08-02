<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PaymentGatewayService;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function createOrder(Request $request)
    {
        $cart = session()->get('cart');
        // Generate unique order number (e.g. ORD-xxxx)
        $orderNumber = 'ORD-' . strtoupper(Str::random(10));

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => $orderNumber,
            'status' => 'pending',
            'payment_status' => 'pending',

            'subtotal' => $cart['subtotal'] ?? $cart['total'], // if you store subtotal separately
            'discount' => $cart['discount'] ?? 0,
            'tax' => $cart['tax'] ?? 0,
            'shipping_cost' => $cart['shipping_cost'] ?? 0,
            'total' => $cart['total'],
            'currency' => 'USD', // Or dynamic based on your store
            'payment_gateway' => 'stripe',
            'shipping_address' => json_encode([
                'name' => $request->shipping['name'],
                'address' => $request->shipping['address'],
                'city' => $request->shipping['city'],
                'phone' => $request->shipping['phone'],
            ]),

            // Optionally billing address as well if available
            'billing_address' => json_encode($request->billing ?? null),
        ]);

        foreach ($cart['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'name' => $item['title'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
                'meta' => json_encode($item['meta'] ?? null),
            ]);
        }

        return response()->json(['order_id' => $order->id]);
    }

    public function createStripeIntent(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $gateway = app(PaymentGatewayService::class)->driver('stripe');

        // Check if a pending transaction for this order already exists
        $existingTransaction = Transaction::where('order_id', $order->id)
            ->where('status', 'pending')
            ->first();

        if ($existingTransaction) {
            // Return the existing client_secret and transaction_id
            return response()->json([
                'client_secret' => $existingTransaction->meta['client_secret'] ?? null,
                'transaction_id' => $existingTransaction->transaction_id,
            ]);
        }

        // Create new charge
        $charge = $gateway->charge($order->total, $order->currency ?? 'usd', ['order_id' => $order->id]);

        // Store transaction with initial status pending
        $transaction = Transaction::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'type' => 'payment',
            'transaction_id' => $charge['transaction_id'] ?? null,
            'amount' => $charge['amount'],
            'currency' => $charge['currency'] ?? $order->currency,
            'status' => 'pending',
            'gateway' => 'stripe',
            'meta' => json_encode($charge['meta'] ?? []),
        ]);

        return response()->json([
            'client_secret' => $charge['client_secret'] ?? null,
            'transaction_id' => $transaction->transaction_id,
        ]);
    }

    public function confirmPayment(Request $request)
    {
        $transaction = Transaction::where('transaction_id', $request->transaction_id)->firstOrFail();

        $transaction->update([
            'status' => 'paid',
        ]);

        $order = $transaction->order;
        $order?->update([
            'status' => 'paid',
            'payment_status' => 'paid',
        ]);

        // Optionally clear cart
        session()->forget('cart');

        return response()->json(['success' => true]);
    }
}
