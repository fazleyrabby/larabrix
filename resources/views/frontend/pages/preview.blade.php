@extends('frontend.app')

@section('content')
    {{-- @foreach ($blocks as $index => $block)
        <div class="block-wrapper relative group border border-dashed border-transparent hover:border-blue-400 rounded-md my-4"
            data-block-id="{{ $index }}" id="{{ $block->type . $index }}">

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
    @endforeach --}}

    <div id="blocks-container" x-data="pageBuilder({{ $page->id }}, window.availableBlocks)"
        @add-block.window="openBlockPicker($event.detail.index, $event.detail.position)">

        @foreach ($blocks as $index => $block)
            @include('frontend.page-partials.block-wrapper', [
                'block' => (object) $block,
                'index' => $index,
            ])
        @endforeach

        <!-- Block Type Selector Modal -->
        <template x-if="showBlockPicker">
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl w-[30rem] max-h-[80vh] overflow-y-auto space-y-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl font-bold">Choose a Block</h2>
                        <button @click="cancelPicker" class="text-gray-400 hover:text-gray-700 text-lg">&times;</button>
                    </div>

                    <template x-for="(block, type) in availableBlocks" :key="type">
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                            <h3 class="font-medium text-lg" x-text="block.label"></h3>
                            <p class="text-sm text-gray-500 mt-1" x-text="block.description"></p>
                            <div class="mt-3">
                                <button @click="selectBlock(type)"
                                    class="inline-flex items-center px-3 py-1.5 text-sm text-blue-600 border border-blue-100 rounded hover:bg-blue-50">
                                    ➕ Add this block
                                </button>
                            </div>
                        </div>
                    </template>

                    <div class="text-center pt-2">
                        <button @click="cancelPicker" class="text-sm text-gray-500 hover:underline">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection


@if (auth()->user()->role === 'admin')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[data-block-id]').forEach(el => {
                    el.style.cursor = 'pointer'; // optional: indicate clickable

                    el.addEventListener('click', e => {
                        e.preventDefault();
                        e.stopPropagation();

                        const blockId = el.getAttribute('data-block-id');
                        if (blockId && window.parent) {
                            window.parent.postMessage({
                                type: 'select-block',
                                id: blockId
                            }, '*'); // Use '*' or restrict origin in production
                        }
                    });
                });
            });
        </script>
        <script>
            window.availableBlocks = @json($availableBlocks);

            document.addEventListener('alpine:init', () => {
                Alpine.store('builder', {
                    showBlockPicker: false,
                    insertIndex: null,
                    insertPosition: 'after',
                    selectedType: null,

                    pickBlock(type = null, position = 'after', index = null) {
                        this.selectedType = type;
                        this.insertIndex = index;
                        this.insertPosition = position;
                        this.showBlockPicker = true;
                    },

                    cancelPicker() {
                        this.showBlockPicker = false;
                        this.insertIndex = null;
                        this.insertPosition = 'after';
                        this.selectedType = null;
                    }
                });
            });

            function pageBuilder(pageId, blockDefinitions = {}) {
                return {
                    blocks: Object.values(@json($blocks)),
                    availableBlocks: blockDefinitions,

                    get showBlockPicker() {
                        return Alpine.store('builder').showBlockPicker;
                    },

                    get insertIndex() {
                        return Alpine.store('builder').insertIndex;
                    },

                    get insertPosition() {
                        return Alpine.store('builder').insertPosition;
                    },

                    pickBlock(type, position, index) {
                        Alpine.store('builder').pickBlock(type, position, index);
                    },

                    cancelPicker() {
                        Alpine.store('builder').cancelPicker();
                    },

                    async selectBlock(type) {
                        const block = this.availableBlocks[type];
                        if (!block) return;

                        const res = await axios.post(`/admin/pages/${pageId}/add-block`, {
                            type,
                            position: this.insertPosition,
                            targetIndex: this.insertIndex
                        });

                        if (res.data.success && res.data.html) {
                            const newEl = document.createElement('div');
                            newEl.id = `block-${res.data.insertIndex}`;
                            newEl.innerHTML = res.data.html;

                            const targetBlock = document.getElementById(`block-${this.insertIndex}`);
                            if (targetBlock) {
                                if (this.insertPosition === 'before') {
                                    targetBlock.parentNode.insertBefore(newEl, targetBlock);
                                } else {
                                    targetBlock.parentNode.insertBefore(newEl, targetBlock.nextSibling);
                                }
                            } else {
                                document.getElementById('blocks-container').appendChild(newEl);
                            }

                            this.cancelPicker();
                            // Update local blocks array (you might want to reload or update your blocks here)
                            // For simplicity, reload page:
                            location.reload();
                        }
                    },

                    moveBlock(index, direction) {
                        if (direction === 'up' && index > 0) {
                            [this.blocks[index - 1], this.blocks[index]] = [this.blocks[index], this.blocks[index - 1]];
                            this.save();
                        } else if (direction === 'down' && index < this.blocks.length - 1) {
                            [this.blocks[index + 1], this.blocks[index]] = [this.blocks[index], this.blocks[index + 1]];
                            this.save();
                        }
                    },

                    async save() {
                        try {
                            const response = await axios.post(`/admin/pages/${pageId}/builder/save`, {
                                page_id: pageId,
                                blocks: this.blocks,
                            });
                            if (response.data.success) {
                                console.log('Page saved successfully');
                                location.reload(); // reload to reflect saved order
                            } else {
                                console.error('Failed to save page:', response.data.message || 'Unknown error');
                            }
                        } catch (error) {
                            console.error('Error saving page:', error);
                        }
                    },

                    removeBlock({
                        index
                    }) {
                        this.blocks.splice(index, 1);
                        this.save();
                    }
                }
            }
        </script>
    @endpush
@endif
