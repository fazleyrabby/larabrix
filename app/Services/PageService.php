<?php

namespace App\Services;

use App\Models\Page;

class PageService
{
    public function getPaginatedItems($params){
        $query = Page::query();
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');
        $query->filter($searchQuery);
        return $query->orderBy('id', 'desc')
              ->paginate($limit)
              ->appends($params);
    }
}