@extends('frontend.app')

@section('content')
    @foreach ($blocks as $index => $block)
        <div class="block-wrapper relative group border border-dashed border-transparent hover:border-blue-400 rounded-md my-4"
            data-block-id="{{ $index }}" id="{{ $block->type . $index }}">

            {{-- Optional: Control Buttons in Builder Mode --}}
            @if (request()->has('builderPreview') && auth()->user()->role == 'admin')
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 hidden group-hover:flex space-x-2 z-10">
                    <button data-insert="before" data-block-id="{{ $index }}"
                        onclick="window.parent.postMessage({
                            type: 'block-insert',
                            position: 'before',
                            targetId: '{{ $index }}'
                        }, '*')"
                        class="btn-insert text-sm px-2 py-1 bg-white border border-gray-300 rounded shadow hover:bg-gray-100">
                        ➕ Add Above
                    </button>
                    
                </div>
            @endif

            @includeIf('frontend.blocks.' . $block->type, [
                'data' => $block->props,
                'index' => $block->type . $index,
            ])

            @if (request()->has('builderPreview') && auth()->user()->role == 'admin')
                <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 hidden group-hover:flex space-x-2 z-10">
                    <button data-insert="after" data-block-id="{{ $index }}"
                        onclick="window.parent.postMessage({
                            type: 'block-insert',
                            position: 'after',
                            targetId: '{{ $index }}'
                        }, '*')"
                        class="btn-insert text-sm px-2 py-1 bg-white border border-gray-300 rounded shadow hover:bg-gray-100">
                        ➕ Add Below
                    </button>
                </div>
            @endif
        </div>
    @endforeach
@endsection
