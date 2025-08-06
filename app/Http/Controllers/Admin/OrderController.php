<?php

namespace App\Http\Controllers\Admin;

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
}
