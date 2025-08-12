<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategories = $request->input('categories');
        $sortBy = $request->input('sort_by');
        $categories = Category::toBase()->select('id','title','is_pc_part')->latest()->get();
        $products = Product::with('category')
            ->when($selectedCategories, function ($query, $selectedCategories) {
                return $query->whereIn('category_id', $selectedCategories);
            })
            ->when($sortBy, function ($query, $sortBy) {
                [$column, $direction] = explode(',', $sortBy);
                return $query->orderBy($column, $direction);
            })
        ->paginate(10)
        ->withQueryString();

        return view('frontend.products.index', compact('products','categories'));
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

        // For the main product image
        $product->image = $product->image ? (Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : Storage::disk('public')->url($product->image)) : '';

        // For the variant images
        $product->variants->transform(function ($v) {
            return [
                'id' => $v->id,
                'price' => $v->price,
                'sku' => $v->sku,
                'image' => $v->image ? (Str::startsWith($v->image, ['http://', 'https://']) ? $v->image : Storage::disk('public')->url($v->image)) : '',
                'attribute_value_ids' => $v->attributeValues->pluck('id')->sort()->values()->all(),
            ];
        });

        return view('frontend.products.show', compact('product', 'attributes'));
    }

    public function pcBuilder(){
        $categories = Category::where('is_pc_part', true)->get();
        $products = Product::whereIn('category_id', $categories->pluck('id'))->get();
        return view('frontend.pc-builder.index', compact('categories','products'));
    }
}
