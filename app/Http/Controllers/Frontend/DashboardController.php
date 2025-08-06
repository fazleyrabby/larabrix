<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->with([
            'items.product',
            'transaction:id,order_id,transaction_id' // include order_id for the relation to work
        ])->orderBy('created_at', 'desc')->paginate(10);

        $userId = auth()->id();
        $oneMonthAgo = Carbon::now()->subMonth();

        $orderCount = DB::table('orders')
            ->where('user_id', $userId)
            ->where('created_at', '>=', $oneMonthAgo)
            ->count();

        $itemCount = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.user_id', $userId)
            ->where('orders.created_at', '>=', $oneMonthAgo)
            ->count('order_items.id');

        $total = DB::table('orders')
            ->where('user_id', $userId)
            ->where('created_at', '>=', $oneMonthAgo)
            ->sum('total');
            

        return view('frontend.dashboard.index', compact('orders','orderCount', 'itemCount','total'));
    }

    public function transactions(){
        $transactions = Transaction::where('user_id', auth()->id())->paginate(10);
        return view('frontend.dashboard.transactions', compact('transactions'));
    }
}
