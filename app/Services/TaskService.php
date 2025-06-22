<?php

namespace App\Services;

use App\Models\Crud;
use App\Models\Menu;
use App\Models\Task;

class TaskService
{
    // public function getPaginatedItems($params){
    //     $query = Menu::with('parent:id,title');
    //     $searchQuery = $params['q'] ?? null;
    //     $limit = $params['limit'] ?? config('app.pagination.limit');
    //     $query->when($searchQuery, fn($q) => $q->search($searchQuery));
    //     $cruds = $query->orderBy('id', 'desc')->paginate($limit)->through(function($crud) {
    //         $crud->created_at = $crud->created_at->diffForHumans();
    //         return $crud;
    //     });
    //     $cruds->appends($params);
    //     return $cruds;
    // }

    public function generateBulkUpdateQueryForTaskSort(array $items)
    {
        if (empty($items)) {
            return;
        }

        $ids = collect($items)->pluck('id')->map(fn($id) => (int) $id);
        $caseTaskStatusId = '';
        $casePosition = '';

        foreach ($items as $item) {
            $id = (int) $item['id'];
            $taskStatusId = (int) $item['task_status_id'];
            $position = (int) $item['position'];

            $caseTaskStatusId .= "WHEN {$id} THEN {$taskStatusId} ";
            $casePosition .= "WHEN {$id} THEN {$position} ";
        }

        $idList = $ids->implode(',');

        $sql = "
            UPDATE tasks
            SET task_status_id = CASE id {$caseTaskStatusId} END,
                position = CASE id {$casePosition} END
            WHERE id IN ({$idList})
        ";

        return $sql;
    }

    public function generateBulkUpdateQueryForTaskStatusSort(array $items)
    {
        if (empty($items)) {
            return;
        }

        $ids = collect($items)->pluck('id')->map(fn($id) => (int) $id);
        $casePosition = '';

        foreach ($items as $item) {
            $id = (int) $item['id'];
            $position = (int) $item['position'];

            $casePosition .= "WHEN {$id} THEN {$position} ";
        }

        $idList = $ids->implode(',');

        $sql = "
            UPDATE task_statuses
            SET position = CASE id {$casePosition} END WHERE id IN ({$idList})
        ";

        return $sql;
    }

    public function isValid($request){
        $taskIds = collect($request->data)->pluck('id');
        $taskStatusId = isset($request->data[0]['task_status_id']) ? $request->data[0]['task_status_id'] : null;
        $tasks = Task::toBase()->select('id', 'position')
                    ->where('task_status_id', $taskStatusId)
                    ->whereIn('id', $taskIds)
                    ->get()->keyBy('id');
        $positionsMatch = collect($request->data)->every(function ($item) use ($tasks) {
            $task = $tasks[$item['id']] ?? (object)[];
            return isset($task->position) && $task->position === (int) $item['position'];
        });
        if($taskIds->count() === count($tasks) && $positionsMatch){
            return false;
        }
        return true;
    }
}
