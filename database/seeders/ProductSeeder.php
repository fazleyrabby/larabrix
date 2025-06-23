<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory()->count(50)->create();
        $products = getDummyProducts();
        $data = array_map(function($product){
            $product['created_at'] = now();
            $product['updated_at'] = now();
            return $product;
        }, $products);

        Product::insert($data);
    }
}
