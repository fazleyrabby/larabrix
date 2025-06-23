<?php


namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function getPaginatedItems($params){
        $query = Product::query()->with('category:id,title');
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');
        $query->filter($searchQuery);
        $products = $query->orderBy('id', 'desc')->paginate($limit)->through(function($product) {
            $product->description = $product->short_description;
            return $product;
        });

        return $products->appends($params);
    }
}
