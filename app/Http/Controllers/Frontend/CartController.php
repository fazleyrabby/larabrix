<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;

class CartController extends Controller
{
    public CartService $service;
    public function __construct(){
        $this->service = new CartService;
    }

    public function add(Request $request)
    {
        $service = $this->service;
        if ($request->has('products') && is_array($request->input('products'))) {
            // Multiple products batch add
            $products = $request->input('products');
            $result = $service->addMultiple($products);
        } else {
            // Single product add
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1);
            $variantId = $request->input('variant_id') ?? null;

            $result = $service->add($productId, $quantity, $variantId);
        }

        $carts = session()->get('cart') ?? [];

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
                'data'    => $carts,
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message'] ?? 'Successfully added to cart!',
            'data'    => $carts,
        ]);
    }

    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $cart = $this->service->update($productId, $quantity);
        return response()->json([
            'success' => true,
            'message' => 'Quantity updated',
            'data' => $cart,
        ]);
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = $this->service->remove($productId);
        return response()->json([
            'message' => 'Item removed successfully.',
            'data' => $cart,
        ]);
    }

    public function cart(){
        return view('frontend.pages.cart');
    }
    
    public function checkout(){
        $stripe = PaymentGateway::where('slug','stripe')->value('config');
        return view('frontend.pages.checkout', compact('stripe'));
    }
    
}
