<?php

namespace App\Services;

use App\Models\Crud;
use App\Models\Menu;

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

    public function generateBulkUpdateQuery(array $items)
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
}
