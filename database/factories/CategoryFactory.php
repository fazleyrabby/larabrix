<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    // public static array $categoryNames = [
    //     'Fruits & Vegetables',
    //     'Dairy Products',
    //     'Beverages',
    //     'Snacks & Confectionery',
    //     'Meat & Poultry',
    //     'Frozen Foods',
    //     'Canned Goods',
    //     'Bakery Items',
    //     'Grains & Pasta',
    //     'Spices & Condiments',
    //     'Household Essentials',
    //     'Personal Care',
    //     'Pet Supplies',
    //     'Health & Wellness',
    //     'Online Exclusives',
    //     'Electronics & Gadgets',
    //     'Clothing & Accessories',
    //     'Home Decor & Furnishings',
    // ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->word(),
        ];
    }
}
