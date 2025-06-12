<?php

namespace App\Services;

use App\Models\Crud;

class CrudService
{
    public function getPaginatedItems($params){
        $query = Crud::query();
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');
        $query->when($searchQuery, function ($q) use ($searchQuery) {
            return $q->where(function ($subQuery) use ($searchQuery) {
                return $subQuery->where('title', 'like', '%'.$searchQuery.'%')
                                ->orWhere('id', 'like', '%'.$searchQuery.'%');
            });
        });
        $cruds = $query->orderBy('id', 'desc')->paginate($limit)->through(function($category) {
            $category->created_at = $category->created_at->diffForHumans();
            return $category;
        });
        $cruds->appends($params);
        return $cruds;
    }
}
