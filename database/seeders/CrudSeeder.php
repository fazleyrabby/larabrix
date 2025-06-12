<?php

namespace Database\Seeders;

use App\Models\Crud;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CrudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Crud::factory()->count(100)->create();
    }
}
