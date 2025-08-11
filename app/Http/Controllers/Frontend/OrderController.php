<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show($id){
        $order = Order::with('items','items.variant','items.variant.attributeValues','transaction')->find($id);
        $attributeIds = $order->items->flatMap(function ($item) {
            return $item->variant && $item->variant->attributeValues
                ? $item->variant->attributeValues->pluck('attribute_id')
                : [];
        })->unique()->values()->toArray();
        $order->shipping_address = json_decode($order->shipping_address);
        $order->meta = json_decode($order->meta);
        return view('frontend.dashboard.orders.show', compact('order'));
    }
}
