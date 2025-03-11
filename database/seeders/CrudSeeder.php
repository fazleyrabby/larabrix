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
        Crud::create([
            'title' => 'Test data',
            'textarea' => fake()->sentence(30),
            'default_file_input' => "",
            'filepond_input' => "",
            'select2' => "",
        ]);

        Crud::create([
            'title' => 'Test data 2',
            'textarea' => fake()->sentence(30),
            'default_file_input' => "",
            'filepond_input' => "",
            'select2' => "",
        ]);
    }
}
