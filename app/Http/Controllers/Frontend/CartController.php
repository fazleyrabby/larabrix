<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public CartService $service;
    public function __construct(){
        $this->service = new CartService;
    }
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $this->service->add($productId, $quantity);

        $carts = session()->get('cart') ?? [];
        return response()->json(['success' => true,'message' => 'Successfully added to cart!','data' => $carts]);
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

    public function checkout(){
        return view('frontend.pages.checkout');
    }
}
