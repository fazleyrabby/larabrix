<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            'Todo',
            'In Progress',
            'Pending',
            'Completed',
            'Test',
            'Backlog',
            'Archived',
        ];

        foreach ($statuses as $index => $title) {
            /** @var \App\Models\TaskStatus $taskStatus */
            $taskStatus = TaskStatus::factory()->create([
                'title' => $title,
                'position' => $index,
            ]);

            // Create between 5 to 10 tasks per status
            $taskCount = rand(5, 10);

            Task::factory()
                ->count($taskCount)
                ->create([
                    'task_status_id' => $taskStatus->id,
                ]);
        }
    }
}
