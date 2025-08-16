<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->count(10)->create();
        Category::create(['title' => 'Motherboard', 'is_pc_part' => true]);
        Category::create(['title' => 'Processor', 'is_pc_part' => true]);
        Category::create(['title' => 'RAM', 'is_pc_part' => true]);
        Category::create(['title' => 'Power Supply', 'is_pc_part' => true]);
        Category::create(['title' => 'Monitor', 'is_pc_part' => true]);
        Category::create(['title' => 'Keyboard', 'is_pc_part' => true]);
        Category::create(['title' => 'Mouse', 'is_pc_part' => true]);
        Category::create(['title' => 'SSD', 'is_pc_part' => true]);
        Category::create(['title' => 'HDD', 'is_pc_part' => true]);
        Category::create(['title' => 'PC Case', 'is_pc_part' => true]);
        Category::create(['title' => 'Cpu Cooler', 'is_pc_part' => true]);
    }
}
