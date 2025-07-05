<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttributeValue>
 */
class AttributeValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Choose a value pool based on existing attribute
        $attribute = Attribute::inRandomOrder()->first() ?? Attribute::factory()->create();
        $valuePool = match (Str::lower($attribute->slug ?? $attribute->title)) {
            'size'    => ['S', 'M', 'L', 'XL'],
            'color'   => ['Red', 'Blue', 'Green', 'Black'],
            'ram'     => ['2GB', '4GB', '8GB'],
            'rom'     => ['64GB', '128GB', '256GB'],
            'display' => ['13.3', '14', '15.6', '19', '21.5', '24', '25', '27','28', '32', '34'],
            default   => [$this->faker->unique()->word()],
        };

        $title = $this->faker->randomElement($valuePool);

        return [
            'attribute_id' => $attribute->id,
            'title'        => $title,
            'slug'         => Str::slug($title),
        ];
    }
}
