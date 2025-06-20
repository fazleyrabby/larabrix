<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected TaskService $service;
    public function __construct(){
        $this->service = new TaskService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function store()
    {
    }

    public function show()
    {
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy($id)
    {
    }

    public function sort(Request $request){
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
            return;
        }
        try {
            $query = $this->service->generateBulkUpdateQuery($request->data);
            DB::statement($query);
            return response()->json(['success' => true, 'message' => 'Successfully updated task list!']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Error occurred: '. $th]);
        }
    }

    public function kanban(){
        $taskStatuses = TaskStatus::select('id', 'title', 'position')
                ->with(['tasks:id,task_status_id,title,position,description'])
                ->orderBy('position')
                ->get();

        return view('admin.tasks.kanban', compact('taskStatuses'));
    }
}
