<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('frontend.products.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with([
            'category',
        ])->firstOrFail();
        $variantIds = ProductVariant::where('product_id', $product->id)->pluck('id');

        $attributeValueIds = DB::table('product_variant_values')
            ->whereIn('product_variant_id', $variantIds)
            ->pluck('attribute_value_id')
            ->unique();

        $attributeIds = AttributeValue::whereIn('id', $attributeValueIds)
            ->pluck('attribute_id')
            ->unique();

        $attributes = Attribute::with(['values' => function ($query) use ($attributeValueIds) {
            $query->whereIn('id', $attributeValueIds);
        }])
        ->whereIn('id', $attributeIds)
        ->get();

        $product->load('variants.attributeValues');
        $product->variants->transform(function ($v) {
            return [
                'id' => $v->id,
                'price' => $v->price,
                'sku' => $v->sku,
                'image' => Storage::disk('public')->url($v->image),
                'attribute_value_ids' => $v->attributeValues->pluck('id')->sort()->values()->all(),
            ];
        });

        return view('frontend.products.show', compact('product', 'attributes'));
    }
}
