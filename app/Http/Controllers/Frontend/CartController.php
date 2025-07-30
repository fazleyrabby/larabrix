<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        app(CartService::class)->add($productId, $quantity);

        $carts = session()->get('cart') ?? [];
        return response()->json(['success' => true,'message' => 'Successfully added to cart!','data' => $carts]);
    }
}
