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

    public function variantCombinations($product){
        return $product->variants->map(function ($variant) {
            $attrs = $variant->attributeValues;
            return [
                'variant_id' => $variant->id,
                'label' => $attrs->pluck('title')->implode(' / '),
                'ids' => $attrs->pluck('id')->all(),
                'price' => $variant->price,
                'sku' => $variant->sku,
                'image' => $variant->image,
                'attr_pairs' => $attrs->map(fn ($attr) => [
                    'attr_id' => $attr->attribute_id,
                    'attr_value_id' => $attr->id,
                ]),
            ];
        });
    }
    public function attributeRows($combinations){
        return $combinations
            ->pluck('attr_pairs')
            ->flatten(1)
            ->groupBy('attr_id')
            ->map(fn ($items, $attrId) => [
                'attr_id' => $attrId,
                'attr_value_ids' => $items->pluck('attr_value_id')->unique()->values()->all(),
            ])
            ->values();
    }
}
