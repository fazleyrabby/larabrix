<li class="card task-item" data-task-id="{{ $task->id }}">
    <div class="card-body text-wrap">
    <h3 class="card-title">{{ $task->title }}</h3>
    <p class="text-secondary">
        {{ $task->description ?? '' }}
    </p>
    </div>
</li>
