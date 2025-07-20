<?php

namespace App\Services;

use App\Models\Crud;
use App\Models\Menu;

class MenuService
{
    public function getPaginatedItems($params){
        $type = $params['type'] ?? 'header';
        $query = Menu::where('type', $type)->with('parent:id,title');
        $searchQuery = $params['q'] ?? null;
        $limit = $params['limit'] ?? config('app.pagination.limit');
        $query->when($searchQuery, fn($q) => $q->search($searchQuery));
        $cruds = $query->orderBy('id', 'desc')->paginate($limit)->through(function($crud) {
            $crud->created_at = $crud->created_at->diffForHumans();
            return $crud;
        });
        $cruds->appends($params);
        return $cruds;
    }

    public function generateBulkUpdateQuery(array $items)
    {
        if (empty($items)) {
            return;
        }

        $ids = collect($items)->pluck('id')->map(fn($id) => (int) $id);
        $caseParentId = '';
        $casePosition = '';

        foreach ($items as $item) {
            $id = (int) $item['id'];
            $parentId = (int) $item['parent_id'];
            $position = (int) $item['position'];

            $caseParentId .= "WHEN {$id} THEN {$parentId} ";
            $casePosition .= "WHEN {$id} THEN {$position} ";
        }

        $idList = $ids->implode(',');

        $sql = "
            UPDATE menus
            SET parent_id = CASE id {$caseParentId} END,
                position = CASE id {$casePosition} END
            WHERE id IN ({$idList})
        ";

        return $sql;
    }
}
