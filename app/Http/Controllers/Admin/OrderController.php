<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $service;
    public function __construct(){
        $this->service = new OrderService;
    }
    public function index(Request $request){
        $orders = $this->service->getPaginatedItems($request->all());
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id){
        $order = $this->getOrder($id);
        return view('admin.orders.show', compact('order'));
    }

    public function edit($id){
        $order = $this->getOrder($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Order $order, Request $request)
    {
        $request->validate([
            'order_status' => ['required', new \Illuminate\Validation\Rules\Enum(OrderStatus::class)],
        ]);
        $order->status = OrderStatus::from($request->order_status);
        $order->payment_status = $request->payment_status;
        $order->save();
        return redirect()
            ->back()
            ->with('success', 'Successfully updated!');
    }

    private function getOrder($id){
        $order = Order::with('user','items','items.variant','items.variant.attributeValues','transaction')->find($id);
        $order->shipping_address = json_decode($order->shipping_address);
        $order->meta = json_decode($order->meta);
        return $order;
    }
}
