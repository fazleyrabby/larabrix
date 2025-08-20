<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\FormSubmission;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        $metrics = [
            'Users' => User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'Orders' => Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'Transactions' => Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'Pages' => Page::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'Form Submissions' => FormSubmission::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
        ];

        return view('admin.dashboard', compact('metrics'));
    }
}
