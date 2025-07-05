<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // foreach (['Size', 'Color', 'RAM'] as $title) {
        //     Attribute::factory()->create([
        //         'title' => $title,
        //         'slug' => Str::slug($title),
        //     ]);
        // }

        // Now create attribute values linked to existing attributes
        // AttributeValue::factory()->count(10)->create();

        $attributes = Attribute::all();

        foreach ($attributes as $attribute) {
            // Define value pools per attribute slug
            $valuePools = [
                'size'    => ['S', 'M', 'L', 'XL'],
                'color'   => ['Red', 'Blue', 'Green', 'Black'],
                'ram'     => ['2GB', '4GB', '8GB'],
                'rom'     => ['64GB', '128GB', '256GB'],
                'display' => ['13.3', '14', '15.6', '19', '21.5'],
            ];

            $slug = Str::lower($attribute->slug);

            $values = $valuePools[$slug] ?? [$attribute->title . ' Option 1', $attribute->title . ' Option 2'];

            foreach ($values as $value) {
                AttributeValue::firstOrCreate([
                    'attribute_id' => $attribute->id,
                    'slug' => Str::slug($value),
                ], [
                    'title' => $value,
                ]);
            }
        }
    }
}
