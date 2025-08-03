<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->with([
            'items.product',
            'transaction:id,order_id,transaction_id' // include order_id for the relation to work
        ])->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.dashboard.index', compact('orders'));
    }
}
