@extends('admin.layouts.app')
@section('title', 'Page Builder')
@section('content')
    <div class="container-fluid components" style="display: flex; height: 100vh;">
        <div id="sidebar" class="p-3" style="width: 350px; min-width: 150px; max-width: 500px; background: #eee; overflow-y:scroll">
            <!-- sidebar content -->
            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-danger mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M15 6l-6 6l6 6" />
                </svg>
                Back
            </a>

            <div>
                {{-- Components  --}}
            </div>
        </div>
        <div id="resizer" style="width: 5px; cursor: ew-resize; background: #ccc;"></div>
        <div id="main" style="flex-grow: 1; background: #fff;height: 100vh;">
            <!-- main content -->
            <iframe
                src="{{ route('frontend.pages.show', $page->slug) }}"
                width="100%"
                height="100%"
                style="border: none;"
            ></iframe>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        const resizer = document.getElementById('resizer');
        const sidebar = document.getElementById('sidebar');
        const container = document.querySelector('.components');

        let isResizing = false;

        resizer.addEventListener('mousedown', function(e) {
            isResizing = true;
        });

        document.addEventListener('mousemove', function(e) {
            if (!isResizing) return;

            // Calculate new width, limit with min and max
            let newWidth = e.clientX - container.getBoundingClientRect().left;
            newWidth = Math.max(150, Math.min(newWidth, 700));
            sidebar.style.width = newWidth + 'px';
        });

        document.addEventListener('mouseup', function(e) {
            isResizing = false;
        });
    </script>
@endpush
