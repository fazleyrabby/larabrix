<?php

namespace App\Services;

use App\Models\Crud;

class CrudService
{
    public function getPaginatedItems($params){
        $query = Crud::query();
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
