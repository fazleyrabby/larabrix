<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Database\Factories\AttributeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = collect(AttributeFactory::$attributeNames)->shuffle();
        $names->each(function ($title) {
            Attribute::firstOrCreate(['slug' => Str::slug($title)], ['title' => $title]);
        });
    }
}
