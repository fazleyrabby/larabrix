@php
    $index = $index ?? 0;
    $block = (object) ($block ?? []);
    $props = $block->props ?? [];
    $type = $block->type ?? 'unknown';
    $id = $type . '-' . now()->timestamp . '-' . rand(0, 999);
@endphp

<div
    class="group block-wrapper relative border border-dashed border-gray-300 rounded-lg mb-6 hover:border-blue-500"
    id="block-{{ $index }}" data-block-id="{{ $block->id ?? $id }}"
    {{-- Important: x-data must be on the outer container (e.g. blocks-container), not here --}}
>
    @if(request()->has('builderPreview') && auth()->check() && auth()->user()->role === 'admin')
        <div
            class="builder-controls absolute -top-6 left-1/2 -translate-x-1/2 flex gap-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
        >
            <button
                class="text-xs px-2 py-1 bg-white border rounded shadow text-gray-700 hover:bg-gray-100"
                @click.prevent="pickBlock('{{ $type }}', 'before', {{ $index }})"
            >➕ Add Above</button>
            <button
                class="text-xs px-2 py-1 bg-white border rounded shadow text-gray-700 hover:bg-gray-100"
                @click.prevent="pickBlock('{{ $type }}', 'after', {{ $index }})"
            >➕ Add Below</button>

            <!-- Move buttons -->
            <button
                class="text-xs px-2 py-1 bg-white border rounded shadow text-gray-700 hover:bg-gray-100"
                @click.prevent="moveBlock({{ $index }}, 'up')"
                :disabled="{{ $index === 0 ? 'true' : 'false' }}"
            >⬆️ Up</button>
            <button
                class="text-xs px-2 py-1 bg-white border rounded shadow text-gray-700 hover:bg-gray-100"
                @click.prevent="moveBlock({{ $index }}, 'down')"
                :disabled="{{ $index === (count($blocks) - 1) ? 'true' : 'false' }}"
            >⬇️ Down</button>
        </div>
    @endif

    {{-- Block Content --}}
    @includeIf('frontend.blocks.' . $type, [
        'data' => $props,
        'index' => $type . $index
    ])
</div>