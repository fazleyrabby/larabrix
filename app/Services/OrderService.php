<?php

namespace App\Services;

use App\Models\Crud;
use App\Models\Menu;
use App\Models\Order;

class OrderService
{
    public function getPaginatedItems($params){
        $query = Order::with([
            'items.product',
            'transaction:id,order_id,transaction_id' // include order_id for the relation to work
        ]);
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');
        $query->when($searchQuery, fn($q) => $q->search($searchQuery));
        $orders = $query->orderBy('created_at', 'desc')->paginate($limit);
        $orders->appends($params);
        return $orders;
    }
}