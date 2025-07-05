<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Database\Seeders\AttributeSeeder;
use Database\Seeders\AttributeValueSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory()->count(50)->create();
        // $products = getDummyProducts();
        // $data = array_map(function($product){
        //     $product['created_at'] = now();
        //     $product['updated_at'] = now();
        //     return $product;
        // }, $products);

        // Product::insert($data);

        // Ensure attributes/values exist
        if (Attribute::count() === 0) {
            $this->call(AttributeSeeder::class);
            $this->call(AttributeValueSeeder::class);
        }

        $attributes = Attribute::with('values')->take(2)->get();

        // 👉 Create 5 simple products
        Product::factory()
            ->count(5)
            ->simple()
            ->create();

        // 👉 Create 5 variable products with variants
        Product::factory()
            ->count(10)
            ->variable()
            ->create()
            ->each(function ($product) use ($attributes) {
                $combinations = collect([[]]);

                foreach ($attributes as $attribute) {
                    $values = $attribute->values;
                    $combinations = $combinations->flatMap(function ($combo) use ($values) {
                        return $values->map(function ($value) use ($combo) {
                            return array_merge($combo, [$value->id]);
                        });
                    });
                }

                foreach ($combinations as $valueIds) {
                    $variant = ProductVariant::factory()->create([
                        'product_id' => $product->id,
                    ]);
                    $variant->attributeValues()->attach($valueIds);
                }
            });
    }
}
