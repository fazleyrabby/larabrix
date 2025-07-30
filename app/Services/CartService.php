<?php


namespace App\Services;

use App\Models\Product;

class CartService
{
    public function add($productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (isset($cart['items'][$productId])) {
            $cart['items'][$productId]['quantity'] += $quantity;
        } else {
            $cart['items'][$productId] = [
                'product_id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'image' => $product->image ? asset($product->image) : 'https://placehold.co/400', 
                'sku' => $product->sku,  
                'quantity' => $quantity,
            ];
        }

        $total = 0;
        foreach ($cart['items'] as $key => $item) {
            // Skip if key is 'total' itself to avoid issues
            if ($key === 'total') {
                continue;
            }
            $total += $item['price'] * $item['quantity'];
        }
        $cart['attributes']['total'] = number_format($total, 2);
        
        session()->put('cart', $cart);
    }
}
