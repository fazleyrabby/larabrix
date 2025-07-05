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
        AttributeValue::factory()->count(10)->create();
    }
}
