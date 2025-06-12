<?php

namespace Database\Factories;

use App\Models\Crud;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crud>
 */
class CrudFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Crud::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'textarea' => $this->faker->sentence(30),
            'default_file_input' => '', // or maybe a fake path?
            'filepond_input' => '',     // same here
            'custom_select' => '',            // or fake()->word() if needed
        ];
    }
}
