@extends('frontend.app')

@section('content')
    <div id="blocks-container" x-data="pageBuilder({{ $page->id }}, window.availableBlocks)"
        @add-block.window="openBlockPicker($event.detail.index, $event.detail.position)">

        @foreach ($blocks as $index => $block)
            @include('frontend.page-partials.block-wrapper', [
                'block' => (object) $block,
                'index' => $index,
            ])
        @endforeach

        <!-- Block Picker Modal -->
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
                        <button @click="cancelPicker" class="text-sm text-gray-500 hover:underline">Cancel</button>
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
                    el.style.cursor = 'pointer';

                    el.addEventListener('click', e => {
                        e.preventDefault();
                        e.stopPropagation();

                        const blockId = el.getAttribute('data-block-id');
                        if (blockId && window.parent) {
                            window.parent.postMessage({
                                type: 'select-block',
                                id: blockId
                            }, '*');
                        }
                    });
                });
            });

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
                        const block = JSON.parse(JSON.stringify(this.availableBlocks[
                        type])); // Deep copy to avoid mutating source
                        if (!block) return;

                        // Assign unique ID to the block
                        block.id = `${type}-${Date.now()}-${Math.floor(Math.random() * 1000)}`;

                        const res = await axios.post(`/admin/pages/${pageId}/add-block`, {
                            type,
                            position: this.insertPosition,
                            targetIndex: this.insertIndex,
                            block: block // Send full block with ID to the backend
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

                            window.parent.postMessage({
                                type: 'refresh-builder',
                            }, '*');
                            this.cancelPicker();
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
                        window.parent.postMessage({
                            type: 'refresh-builder',
                        }, '*');
                    },

                    async save() {
                        try {
                            const response = await axios.post(`/admin/pages/${pageId}/builder/save`, {
                                page_id: pageId,
                                blocks: this.blocks,
                            });
                            if (response.data.success) {
                                location.reload();
                            } else {
                                console.error('Save failed:', response.data.message || 'Unknown error');
                            }
                        } catch (error) {
                            console.error('Error during save:', error);
                        }
                    },

                    removeBlock({
                        index
                    }) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This block will be permanently deleted!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.blocks.splice(index, 1);
                                this.save();
                            }
                        });
                    }
                }
            }
        </script>
    @endpush
@endif
