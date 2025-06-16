<?php

namespace App\Services;

use App\Models\Crud;
use App\Models\Menu;

class MenuService
{
    public function getPaginatedItems($params){
        $query = Menu::with('parent:id,title');
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');
        $query->when($searchQuery, fn($q) => $q->search($searchQuery));
        $cruds = $query->orderBy('id', 'desc')->paginate($limit)->through(function($crud) {
            $crud->created_at = $crud->created_at->diffForHumans();
            return $crud;
        });
        $cruds->appends($params);
        return $cruds;
    }
}
