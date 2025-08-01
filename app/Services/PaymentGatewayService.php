<?php

namespace App\Services;

use App\Models\Crud;
use App\Models\PaymentGateway;

class PaymentGatewayService
{
    public function getPaginatedItems($params){
        $query = PaymentGateway::query();
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');
        $query->when($searchQuery, fn($q) => $q->search($searchQuery));
        $cruds = $query->orderBy('id', 'desc')->paginate($limit);
        $cruds->appends($params);
        return $cruds;
    }
}