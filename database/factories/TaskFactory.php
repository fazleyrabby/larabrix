<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'task_status_id' => TaskStatus::factory(),
            'title' => fake()->randomElement([
                'Implement login authentication',
                'Fix navigation bug',
                'Create user profile page',
                'Design dashboard layout',
                'Write unit tests',
                'Optimize queries',
                'Integrate payment gateway',
                'Deploy to staging',
                'Dark mode toggle',
                'Review PR #42',
            ]),
            'description' => fake()->sentence(12),
            'position' => fake()->numberBetween(0, 20),
        ];
    }
}
