<?php


namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Traits\UploadPhotos;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ProductService
{
    use UploadPhotos;
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

    public function storeCombinations($request, Product $product, $oldVariants = [])
    {
        $combinations = $request->combinations ?? [];
        $savedVariantIds = [];

        foreach ($combinations as $combination) {
            $variant = null;

            if (!empty($combination['variant_id'])) {
                $variant = ProductVariant::find($combination['variant_id']);

                if ($variant) {
                    $image = $variant->image;

                    if (isset($combination['image']) && is_string($combination['image'])) {
                        $image = $combination['image'];
                    }

                    $variant->update([
                        'sku' => $combination['sku'],
                        'price' => $combination['price'],
                        'image' => $image,
                    ]);

                    $variant->attributeValues()->sync($combination['ids']);

                    $savedVariantIds[] = $variant->id;
                    continue;
                }
            }

            $image = null;
            if (!empty($combination['image']) && is_string($combination['image'])) {
                // Just store the image path from the selected gallery image
                $image = $combination['image'];
            } elseif ($oldVariants && isset($combination['variant_id'])) {
                // Use previous variant image if available
                $image = $oldVariants[$combination['variant_id']]->image ?? null;
            }

            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'sku' => $combination['sku'],
                'price' => $combination['price'],
                'image' => $image,
            ]);

            $variant->attributeValues()->attach($combination['ids']);

            $savedVariantIds[] = $variant->id;
        }

        $product->variants()
            ->whereNotIn('id', $savedVariantIds)
            ->get()
            ->each(function ($variant) {
                $variant->attributeValues()->detach();
                $variant->delete(); // soft delete
            });
    }
}
