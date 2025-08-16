<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title'        => $title = $this->faker->sentence(3),
            'slug'         => Str::slug($title), // create slug from title
            'type'         => 'variable',
            'sku'          => strtoupper(Str::random(10)),
            'price'        => null, // price comes from variants
            'image'        => null,
            'description'  => $this->faker->paragraph(),
            'category_id'  => \App\Models\Category::factory(),
            'brand_id'     => rand(1, 10),
        ];
    }

    public function variable(): self
    {
        return $this->state(fn () => ['type' => 'variable']);
    }

    public function simple(): self
    {
        return $this->state(fn () => [
            'type' => 'simple',
            'sku' => strtoupper(Str::random(10)),
            'price' => $this->faker->randomFloat(2, 5, 99),
        ]);
    }

    // public function definition()
    // {
    //     $purchasePrice = $this->faker->randomFloat(2, 10, 200);
    //     return [
    //         'title' => $this->faker->unique()->word(),  // Random word for product name
    //         'description' => $this->faker->sentence(),  // Random sentence for description
    //         'sku' => $this->faker->word() . '_' . uniqid() . '_' . time(),  // Random sentence for description
    //         'category_id' => $this->faker->numberBetween(1, 3),  // Random sentence for description
    //         'supplier_id' => $this->faker->numberBetween(1, 5),  // Random sentence for description
    //         'purchase_price' => $purchasePrice,  // Random price between 10 and 500
    //         'sale_price' => $purchasePrice + 2,  // Random price between 10 and 500
    //         // 'quantity' => $this->faker->numberBetween(1, 20),  // Random quantity between 1 and 100
    //         'image' => '',
    //         // 'image' => UploadedFile::fake()->image('test_product_' . uniqid() . '.png', 640, 480),
    //         // 'image' => function () {
    //         //     $fakeImage = UploadedFile::fake()->image('test_product.png', 640, 480);
    //         //     $filename = 'uploads/' . uniqid() . '_test_product.png';
    //         //     Storage::disk('public')->put($filename, (string) $fakeImage->getContent());
    //         //     return $filename;
    //         // },
    //     ];
    // }
}
