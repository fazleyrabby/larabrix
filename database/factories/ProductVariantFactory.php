<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition(): array
    {
        return [
            'sku'        => 'SKU-' . strtoupper(Str::random(8)),
            'price'      => $this->faker->randomFloat(2, 100, 999),
            // 'stock'      => $this->faker->numberBetween(0, 100),
            'product_id' => null, // set manually in seeder
        ];
    }
}
