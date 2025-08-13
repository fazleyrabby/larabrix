<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CheckoutService;
use App\Services\PaymentGatewayService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;

class CheckoutController extends Controller
{
    protected CheckoutService $service;

    public function __construct(CheckoutService $service){
        $this->service = $service;
    }
    // public function createOrder(Request $request)
    // {
    //     try {
    //         $cart = session()->get('cart');

    //         if (!$cart || empty($cart['items'])) {
    //             return response()->json(['error' => 'Cart is empty.'], 400);
    //         }

    //         $orderNumber = 'ORD-' . strtoupper(Str::random(10));

    //         $order = Order::create([
    //             'user_id' => auth()->id(),
    //             'order_number' => $orderNumber,
    //             'status' => 'pending',
    //             'payment_status' => 'pending',
    //             'subtotal' => $cart['subtotal'] ?? $cart['total'],
    //             'discount' => $cart['discount'] ?? 0,
    //             'tax' => $cart['tax'] ?? 0,
    //             'shipping_cost' => $cart['shipping_cost'] ?? 0,
    //             'total' => $cart['total'],
    //             'currency' => 'USD',
    //             'payment_gateway' => 'stripe',
    //             'shipping_address' => json_encode($request->shipping ?? []),
    //             'billing_address' => json_encode($request->billing ?? null),
    //         ]);

    //         foreach ($cart['items'] as $item) {
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $item['product_id'],
    //                 'name' => $item['title'],
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item['price'],
    //                 'total' => $item['price'] * $item['quantity'],
    //                 'meta' => json_encode($item['meta'] ?? null),
    //             ]);
    //         }

    //         return response()->json(['order_id' => $order->id]);
    //     } catch (Exception $e) {
    //         Log::error('Order creation failed', ['error' => $e->getMessage()]);
    //         return response()->json(['error' => 'Failed to create order.'], 500);
    //     }
    // }

     /**
     * Create a Stripe PaymentIntent for the order.
     * This method remains the same and is specifically for Stripe payments.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createStripeIntent(Request $request)
    {
        try {
            $cart = session()->get('cart');
            $currency = 'usd';

            $gateway = app(PaymentGatewayService::class)->driver('stripe');

            $totalAmount = str_replace(',', '', $cart['total']);
            $totalAmount = (float) $totalAmount;
            $charge = $gateway->charge($totalAmount, $currency, [
                'shipping' => json_encode($request->shipping),
            ]);

            $transaction = $this->service->createTransactionFromStripeCharge($charge);

            return response()->json([
                'client_secret' => $charge['client_secret'],
                'transaction_id' => $transaction->transaction_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe intent creation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create payment intent.'], 500);
        }
    }

    /**
     * Confirms the payment and creates the order, handling both Stripe and Cash on Delivery.
     * The payment confirmation logic has been updated to be more flexible and optimized.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmPayment(Request $request)
    {
        try {
            $cart = session()->get('cart');

            // Check for empty cart once
            if (!$cart || empty($cart['items'])) {
                return response()->json(['error' => 'Cart is empty.'], 400);
            }

            $this->service->handlePaymentConfirmation($request, $cart);

            // Clear the cart session after a successful order creation
            session()->forget('cart');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Payment confirmation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to confirm order.'], 500);
        }
    }

    public function complete(Request $request)
    {
        // $trxId = $request->get('transaction_id');
        return view('frontend.pages.payment-complete');
    }
}
