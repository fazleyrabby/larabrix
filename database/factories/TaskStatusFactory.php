<?php

namespace Database\Factories;

use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskStatusFactory extends Factory
{
    protected $model = TaskStatus::class;

    public function definition(): array
    {
        return [
            'title' => fake()->randomElement([
                'Todo', 'In Progress', 'Pending', 'Completed', 'Test', 'Backlog', 'Archived',
            ]),
            'position' => fake()->unique()->numberBetween(0, 10),
        ];
    }
}
