@extends('admin.layouts.app')
@section('container-class','layout-fluid')
@section('title', 'Kanban Board')
@push('styles')
<style>
    .kanban-scroll-wrapper {
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 1rem; /* some spacing */
    }
    .sortable-ghost {
        opacity: 0.4;
    }
    .sortable-chosen {
        background: #f1f3f5;
    }
    .drop-target-highlight {
        border: 2px dotted #6c757d;
        border-radius: 0.5rem;
        background-color: #f8f9fa; /* optional */
        transition: background-color 0.2s ease;
    }
</style>
@endpush
@section('content')
<!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Demo Project
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
          <div class="kanban-scroll-wrapper overflow-auto">
            <div class="task-container d-flex flex-nowrap gap-3" data-sortable-type="container">
                @foreach ($taskStatuses as $taskStatus)
                    <div class="card" data-task-status-id="{{ $taskStatus->id }}" style="min-width: 350px; max-height: calc(100vh - 200px);">
                    <div class="card-header">
                        <h3 class="card-title">{{ $taskStatus->title }}</h3>
                    </div>
                        <div class="card-body" style="background-color: #F9FAFB; overflow:scroll">
                            <ul class="tasks d-flex flex-column gap-2 p-0"
                                data-sortable-type="items"
                                data-task-status-id="{{ $taskStatus->id }}">
                                @foreach ($taskStatus?->tasks as $task)
                                    @include('admin.tasks.task', ['task'=> $task])
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
          </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js" integrity="sha512-csIng5zcB+XpulRUa+ev1zKo7zRNGpEaVfNB9On1no9KYTEY/rLGAEEpvgdw6nim1WdTuihZY1eqZ31K7/fZjw==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll('.tasks').forEach(initSortable);
        initSortable(document.querySelector('.task-container'));
    });
    function clearDropTargets() {
        document.querySelectorAll('.tasks').forEach(el => el.classList.remove('drop-target-highlight'));
    }
    function processTasks(evt){
        const items = [];
        const movedItem = evt.item
        const movedToList = evt.to
        const taskId = movedItem.dataset.taskId
        const movedToListParentId = movedToList.dataset.taskStatusId
        let route = "/admin/tasks/sort";
        if(movedToList.classList.contains('task-container')){
            route = '/admin/tasks/status/sort'
            Array.from(movedToList.children).forEach((child, index) => {
                const id = parseInt(child.dataset.taskStatusId);
                items.push({
                    id: id,
                    position: index,
                });
            })

        }else{
            Array.from(movedToList.children).forEach((child, index) => {
                const id = parseInt(child.dataset.taskId);
                items.push({
                    id: id,
                    task_status_id: movedToListParentId,
                    position: index,
                });
            })
        }

        return sort(route, items);
    }

    function sort(route, items){
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        axios.post(route, {data: items})
        .then(({data}) => {
            console.log(data)
            if(data) toast(data.success ? 'success': 'error', data.message)
        })
        .catch(error => {
            if (error.response) {
            console.error('Validation errors:', error.response.data.errors);
            } else {
            console.error('Error saving task:', error.message);
            }
        });
    }
    function addDropTarget(event) {
        if (event.to.classList.contains('tasks')) {
            event.to.classList.add('drop-target-highlight');
        }
    }
    function initSortable(container) {
        new Sortable(container, {
            group: container.dataset.sortableType,
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.5,
            fallbackTolerance: 10,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            scroll: true,
            scrollSensitivity: 100,   // px distance from edge to trigger scroll
            scrollSpeed: 15,
            onMove: function (evt) {
                // Remove from all lists first
                clearDropTargets()
                addDropTarget(evt)
            },

            onEnd: function (evt) {
                clearDropTargets()
                processTasks(evt)
            }
        });
    }
</script>
@endpush
