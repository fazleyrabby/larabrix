<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    public static array $attributeNames = [
        'Size',
        'Color',
        'RAM',
        'ROM',
        'Display',
        'Material',
        'Storage',
        'Processor',
        'Battery',
        'Weight',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pick a unique name from the list
        $title = $this->faker->unique()->randomElement(self::$attributeNames);

        return [
            'title' => $title,
            'slug'  => Str::slug($title),
        ];
    }
}
