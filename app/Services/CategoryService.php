<?php


namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class CategoryService
{
    public function getPaginatedItems($params){
        $query = Category::query();
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');
        $query->when($searchQuery, function ($q) use ($searchQuery) {
            return $q->where(function ($subQuery) use ($searchQuery) {
                return $subQuery->where('title', 'like', '%'.$searchQuery.'%')
                                ->orWhere('id', 'like', '%'.$searchQuery.'%');
            });
        });
        $categories = $query->orderBy('id', 'desc')->paginate($limit)->through(function($category) {
            $category->created_at = $category->created_at->diffForHumans();
            return $category;
        });
        $categories->appends($params);

        return $categories;
    }
}
