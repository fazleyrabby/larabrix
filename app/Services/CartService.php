<?php


namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;

class CartService
{
    public function add($productId, $quantity = 1, $variantId = null)
    {
        $cart = session()->get('cart', []);
        $result = $this->addOrUpdateCartItem($cart, $productId, $quantity, $variantId);

        session()->put('cart', $result['cart']);

        return [
            'success' => !$result['exceeded'],
            'message' => $result['exceeded'] ? 'Maximum quantity for this product is 10.' : 'Successfully added to cart!',
        ];
    }

     /**
     * Public method to add multiple products at once
     */
    public function addMultiple(array $products)
    {
        $cart = session()->get('cart', []);
        $messages = [];
        $success = true;

        foreach ($products as $item) {
            $productId = $item['product_id'] ?? null;
            $quantity = $item['quantity'] ?? 1;
            $variantId = $item['variant_id'] ?? null;

            if (!$productId) {
                continue;
            }

            $result = $this->addOrUpdateCartItem($cart, $productId, $quantity, $variantId);
            $cart = $result['cart'];

            if ($result['exceeded']) {
                $success = false;
                $messages[] = "Product ID {$productId}: Maximum quantity for this product is 10.";
            } else {
                $messages[] = "Product ID {$productId}: Successfully added to cart!";
            }
        }

        session()->put('cart', $cart);

        return [
            'success' => $success,
            'message' => implode('|', $messages),
            'cart' => $cart,
        ];
    }

    /**
     * Private helper to add or update a cart item
     */
    private function addOrUpdateCartItem(array $cart, int $productId, int $quantity, ?int $variantId)
    {
        // Use unique key for product + variant combo
        $key = $productId . '_' . ($variantId ?? 'default');

        $currentQty = $cart['items'][$key]['quantity'] ?? 0;
        $newQuantity = $currentQty + $quantity;

        $exceeded = false;
        if ($newQuantity > 10) {
            $newQuantity = 10;
            $exceeded = true;
        }

        if (isset($cart['items'][$key])) {
            $cart['items'][$key]['quantity'] = $newQuantity;
        } else {
            $product = Product::findOrFail($productId);

            $price = $product->price;
            $sku = $product->sku;
            $image = $product->image ? asset($product->image) : 'https://placehold.co/400';

            if ($variantId) {
                $variant = ProductVariant::find($variantId);
                if ($variant) {
                    if ($variant->price !== null) {
                        $price = $variant->price;
                    }
                    if ($variant->sku) {
                        $sku = $variant->sku;
                    }
                    if ($variant->image ?? false) {
                        $image = asset($variant->image);
                    }
                }
            }

            $cart['items'][$key] = [
                'product_id' => $product->id,
                'variant_id' => $variantId,
                'title'      => $product->title,
                'price'      => $price,
                'image'      => $image,
                'sku'        => $sku,
                'quantity'   => $newQuantity,
                'attributes' => [],
            ];
        }

        $cart = $this->updateTotal($cart);

        return [
            'cart' => $cart,
            'exceeded' => $exceeded,
        ];
    }

    public function update($productId, $quantity)
    {
        $cart = session()->get('cart');
        if (isset($cart['items'][$productId])) {
            $cart['items'][$productId]['quantity'] = $quantity;
        }
        $cart = $this->updateTotal($cart);
        session()->put('cart', $cart);
        return $cart;
    }

    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        logger('Removing from cart:', ['productId' => $productId, 'cartKeys' => array_keys($cart['items'] ?? [])]);
        if (isset($cart['items'][$productId])) {
            unset($cart['items'][$productId]);
        }
        $cart = $this->updateTotal($cart);
        session()->put('cart', $cart);
        return $cart;
    }

    private function updateTotal($cart)
    {
        $total = 0;
        foreach ($cart['items'] as $key => $item) {
            // Skip if key is 'total' itself to avoid issues
            if ($key === 'total') {
                continue;
            }
            $total += $item['price'] * $item['quantity'];
        }
        $cart['total'] = number_format($total, 2);
        return $cart;
    }
}
