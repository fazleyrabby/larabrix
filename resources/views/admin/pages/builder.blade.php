@extends('admin.layouts.app')
@section('title', 'Page Builder')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <style>
        .block {
            cursor: grab;
        }

        #sidebar-left,
        #sidebar-right {
            background: #eee;
            overflow-y: auto;
            height: 100vh;
            padding: 1rem;
        }

        #sidebar-left {
            width: 300px;
            min-width: 150px;
            max-width: 400px;
            border-right: 1px solid #ccc;
        }

        #sidebar-right {
            width: 400px;
            min-width: 300px;
            max-width: 500px;
            border-left: 1px solid #ccc;
        }

        #main {
            flex-grow: 1;
            background: #fff;
            height: 100vh;
        }

        #resizer-left,
        #resizer-right {
            width: 5px;
            cursor: ew-resize;
            background: #ccc;
            height: 100vh;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid components" x-data="builder" x-init="init()"
        style="display: flex; height: 100vh;">
        {{-- LEFT SIDEBAR: Block list --}}
        <div id="sidebar-left" data-route="{{ route('admin.pages.builder.store', $page->id) }}">
            <div class="d-flex justify-content-between mb-2">
                <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-danger btn-sm">Back</a>
                <a class="btn btn-info btn-sm" href="{{ route('frontend.pages.show', $page->slug) }}" target="_blank">View
                    Page</a>
            </div>

            <div x-ref="sortableContainer" class="block-sortable">
                <template x-for="(block, index) in blocks" :key="block.id">
                    <div class="block-item position-relative d-flex align-items-center mb-2" :data-id="block.id"
                        style="min-height: 42px;">
                        <button class="block w-full p-2 border rounded"
                            :class="{ 'bg-black text-white': index === selected }" @click="selectBlock(index)">
                            <span x-text="(block.label || 'Block') + ' ' + (index + 1)"></span>
                        </button>
                        <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y me-2"
                            :class="{ ' text-white': index === selected }" aria-label="Remove"
                            @click.stop="removeBlock(index)">
                        </button>
                    </div>
                </template>
            </div>
            <div class="dropdown my-4">
                <button class="btn btn-outline-secondary dropdown-toggle w-100 btn-append" type="button"
                    data-bs-toggle="dropdown">
                    ➕ Add Block
                </button>
                <ul class="dropdown-menu w-100">
                    <template x-for="(block, type) in blockOptions" :key="type">
                        <li>
                            <a class="dropdown-item" href="#" @click.prevent="addBlock(type)"
                                x-text="block.label"></a>
                        </li>
                    </template>
                </ul>
            </div>

            <button @click="save()" class="btn btn-primary w-100">Save</button>
        </div>


        {{-- RESIZER BETWEEN LEFT SIDEBAR AND MAIN --}}
        <div id="resizer-left"></div>

        {{-- MAIN IFRAME PREVIEW --}}
        <div id="main">
            <iframe id="page-builder-preview" src="{{ route('frontend.pages.preview', $page->slug) }}?builderPreview=1"
                width="100%" height="100%" class="border rounded"></iframe>
        </div>

        {{-- RESIZER BETWEEN MAIN AND RIGHT SIDEBAR --}}
        <div id="resizer-right"></div>

        {{-- RIGHT SIDEBAR: Block editing form --}}
        <div id="sidebar-right" style="width: 350px; overflow-y: auto; border-left: 1px solid #ddd; padding: 1rem;">
            <template x-if="selected !== null && blocks[selected]">
                <div class="space-y-3">
                    <h5>Edit Block: <span x-text="blocks[selected].label || blocks[selected].type"></span></h5>
                    @php
                        $baseUrl = url('/');
                    @endphp
                    <template x-for="(value, key) in blocks[selected].props" :key="key">
                        <div class="mb-3">
                            <template x-if="value.type == 'image'">
                                <div>
                                    <label class="form-label fw-bold" x-text="key"></label>

                                    <!-- Image Preview -->
                                    <div class="mb-2">
                                        <img :src="blocks[selected].props[key].value ? '{{ $baseUrl }}/' + blocks[selected]
                                            .props[
                                                key].value.replace(/^\/+/, '') : 'https://placehold.co/400'"
                                            class="img-fluid rounded border" style="max-height: 150px;" alt="Preview">
                                    </div>

                                    <!-- Image URL input -->
                                    <input type="text" class="form-control mb-2" placeholder="Image URL"
                                        x-model="blocks[selected].props[key].value">

                                    <!-- Media Manager Trigger -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas"
                                        data-bs-target="#builder-offcanvas" data-type="builder" :data-key="key"
                                        @click="$store.mediaManager.targetKey = key">
                                        Upload File
                                    </button>
                                </div>
                            </template>

                            <template
                                x-if="blocks[selected].props[key]?.type === 'repeater' && Array.isArray(blocks[selected].props[key].value)">
                                <div>
                                    <label class="form-label fw-bold mb-1" x-text="key"></label>

                                    <template x-for="(item, idx) in blocks[selected].props[key].value"
                                        :key="idx">
                                        <div class="p-3 mb-3 border rounded bg-light">
                                            <template x-for="(fieldSchema, fieldKey) in blocks[selected].props[key].fields"
                                                :key="fieldKey">
                                                <div class="mb-2">
                                                    <label class="form-label" x-text="fieldKey"></label>
                                                    <input type="text" class="form-control"
                                                        x-model="blocks[selected].props[key].value[idx][fieldKey]">
                                                </div>
                                            </template>

                                            <!-- Remove button -->
                                            <button type="button" class="btn btn-sm btn-danger mt-2"
                                                @click="blocks[selected].props[key].value.splice(idx, 1)">Remove</button>
                                        </div>
                                    </template>

                                    <!-- Add New Item -->
                                    <button type="button" class="btn btn-sm btn-primary mt-2"
                                        @click="blocks[selected].props[key].value.push(
                                                Object.fromEntries(Object.keys(blocks[selected].props[key].fields).map(k => [k, '']))
                                            )">
                                        + Add New
                                    </button>
                                </div>
                            </template>

                            <!-- Normal field (non-array, non-object) -->
                            <template
                                x-if="(key !== 'background_image' && key !== 'image' && key !== 'form_id') && (!Array.isArray(value?.value) || typeof value?.value[0] !== 'object') && typeof value?.value !== 'object'">
                                <div>
                                    <label class="form-label fw-bold" x-text='key'></label>
                                    <template x-if="value.type === 'textarea'">
                                        <div x-data x-init="() => {
                                            const quill = new Quill($refs.editor, { theme: 'snow' });
                                            quill.on('text-change', () => {
                                                blocks[selected].props[key].value = quill.root.innerHTML;
                                            });
                                            quill.root.innerHTML = blocks[selected].props[key].value || '';
                                        }">
                                            <div x-ref="editor" class="bg-white border rounded" style="min-height: 150px;">
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="value.type !== 'textarea'">
                                        <input type="text" class="form-control"
                                            x-model="blocks[selected].props[key].value" />
                                    </template>
                                </div>
                            </template>

                            <!-- Special: form_id dropdown -->
                            <template x-if="key === 'form_id'">
                                <div>
                                    <label class="form-label fw-bold">Select Form</label>
                                    <select class="form-control" x-model="blocks[selected].props[key].value">
                                        <option value="">-- Select a Form --</option>
                                        <template x-for="[id, name] in Object.entries(forms)" :key="id">
                                            <option :value="String(id)" x-text="name"></option>
                                        </template>
                                    </select>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>

            @include('admin.components.media.popup', [
                'modalId' => 'builder-offcanvas',
                'inputType' => 'single',
                'from' => 'builder',
            ])

            <template x-if="selected === null">
                <div class="text-muted">Select a block on the left to edit its properties.</div>
            </template>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js"
        integrity="sha512-csIng5zcB+XpulRUa+ev1zKo7zRNGpEaVfNB9On1no9KYTEY/rLGAEEpvgdw6nim1WdTuihZY1eqZ31K7/fZjw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('builder', () => ({
                blocks: JSON.parse(@json($page->builder ?? '[]')).map(block => ({
                    ...block,
                    id: block.id ||
                        `${block.type}-${Date.now()}-${Math.floor(Math.random() * 1000)}`
                })),
                selected: null,
                blockOptions: @json($pageBlocks),
                sortableInstance: null,
                sortedIds: [],
                forms: @json($forms),

                init() {
                    if (this.blocks.length > 0 && this.selected === null) {
                        this.selected = 0;
                    }
                    this.initSortable();
                    window.addEventListener('message', (event) => {
                        if (event.data?.type === 'refresh-builder') {
                            location.reload();
                        }
                        if (event.data && event.data.type === 'select-block' && event.data.id) {
                            const blockIndex = this.blocks.findIndex(b => b.id === event.data
                                .id);
                            if (blockIndex !== -1) {
                                this.selected = blockIndex;
                            }
                        }
                    });

                    this.$nextTick(() => {
                        this.initSortable();
                    });
                },

                initSortable() {
                    const self = this;

                    if (self.sortableInstance) {
                        self.sortableInstance.destroy();
                    }

                    self.sortableInstance = Sortable.create(self.$refs.sortableContainer, {
                        animation: 150,
                        handle: '.block-item',
                        onEnd: () => { // use arrow function here
                            this.sortedIds = Array.from(self.$refs.sortableContainer
                                    .querySelectorAll('[data-id]'))
                                .map(el => el.getAttribute('data-id'));
                        }
                    });
                },

                selectBlock(index) {
                    this.selected = index;
                },

                addBlock(type) {
                    const template = JSON.parse(JSON.stringify(this.blockOptions[type] || {}));
                    const id = `${type}-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
                    this.blocks.push({
                        id,
                        type,
                        label: template.label || type,
                        props: template.props || {}
                    });
                    this.selected = this.blocks.length - 1;
                    console.log(this.blocks)
                },

                getReorderedBlocks(blocks, sortedIds) {
                    if (!sortedIds || !sortedIds.length) {
                        // If no sorted IDs, return all blocks with their IDs intact
                        return blocks;
                    }

                    const map = Object.fromEntries(blocks.map(block => [block.id, block]));

                    return sortedIds
                        .map(id => map[id])
                        .filter(Boolean); // remove any nulls if id not found
                },

                removeBlock(index) {
                    if (confirm('Are you sure you want to delete this block?')) {
                        this.blocks.splice(index, 1);
                        if (this.selected === index) this.selected = null;
                        else if (this.selected > index) this.selected--;
                    }
                },

                save() {
                    const sortedBlocks = this.getReorderedBlocks(this.blocks, this.sortedIds);
                    axios.post('{{ route('admin.pages.builder.store', $page->id) }}', {
                            builder: sortedBlocks
                        })
                        .then(() => {
                            alert('Page saved!');
                            document.getElementById('page-builder-preview').contentWindow.location
                                .reload();
                        })
                        .catch(e => {
                            alert('Failed to save');
                            console.error(e);
                        });
                }
            }));
            // Alpine store for media manager
            Alpine.store('mediaManager', {
                targetKey: null,
                insertImage(url, fullPath) {
                    // console.log(fullPath)
                    const builderComponent = document.querySelector('[x-data="builder"]')?._x_dataStack?.[
                        0
                    ];
                    // console.log(builderComponent)
                    if (!builderComponent || builderComponent.selected === null || !this.targetKey) return;

                    const block = builderComponent.blocks[builderComponent.selected];
                    console.log(this.targetKey)
                    if (!block.props) block.props = {};

                    // Just store the relative path like "storage/images/example.jpg"
                    block.props[this.targetKey] = {
                        type: 'image',
                        value: url
                    };
                    console.log(block.props)
                    this.targetKey = null;
                }
            });
        });

        // Resizer for left sidebar
        const resizerLeft = document.getElementById('resizer-left');
        const sidebarLeft = document.getElementById('sidebar-left');
        const container = document.querySelector('.components');
        let isResizingLeft = false;

        resizerLeft.addEventListener('mousedown', e => {
            isResizingLeft = true;
            document.body.style.cursor = 'col-resize';
            document.body.style.userSelect = 'none';
        });

        document.addEventListener('mouseup', e => {
            isResizingLeft = false;
            document.body.style.cursor = '';
            document.body.style.userSelect = '';
        });

        document.addEventListener('mousemove', e => {
            if (!isResizingLeft) return;
            const containerLeft = container.getBoundingClientRect().left;
            let newWidth = e.clientX - containerLeft;
            newWidth = Math.max(150, Math.min(newWidth, 500));
            sidebarLeft.style.width = newWidth + 'px';
        });

        // Resizer for right sidebar
        const resizerRight = document.getElementById('resizer-right');
        const sidebarRight = document.getElementById('sidebar-right');
        let isResizingRight = false;

        resizerRight.addEventListener('mousedown', e => {
            isResizingRight = true;
            document.body.style.cursor = 'col-resize';
            document.body.style.userSelect = 'none';
        });

        document.addEventListener('mouseup', e => {
            isResizingRight = false;
            document.body.style.cursor = '';
            document.body.style.userSelect = '';
        });

        document.addEventListener('mousemove', e => {
            if (!isResizingRight) return;
            const containerRight = container.getBoundingClientRect().right;
            let newWidth = containerRight - e.clientX;
            newWidth = Math.max(150, Math.min(newWidth, 600));
            sidebarRight.style.width = newWidth + 'px';
        });
    </script>
@endpush
