@extends('admin.layouts.app')
@section('title', 'Page Builder')
@section('content')
    <div class="container-fluid components" style="display: flex; height: 100vh;">
        <div id="sidebar" class="p-3"
            style="width: 350px; min-width: 150px; max-width: 500px; background: #eee; overflow-y:scroll">
            <!-- sidebar content -->
            <div class="d-flex justify-content-between mb-2">
                <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-danger btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M15 6l-6 6l6 6" />
                </svg>
                Back
                </a>

                <a class="btn btn-info btn-sm" href="{{ route('frontend.pages.show', $page->slug) }}">View Page</a>
            </div>

            @php
                $baseUrl = url('/'); 
            @endphp

            <div x-data="builder" class="w-1/3 p-4 border-r" x-init="route = $el.dataset.route"
                data-route="{{ route('admin.pages.builder.store', $page->id) }}">
                <template x-for="(block, index) in blocks" :key="index">
                    <button class="block w-full mb-2 p-2 border rounded"
                        :class="{ 'bg-black text-white': index === selected }" @click="selectBlock(index)">
                        <span x-text="(block.label || 'Block') + ' ' + (index + 1)"></span>
                    </button>
                </template>

                <div x-show="selected !== null" class="mt-4 space-y-2">
                    <template x-if="blocks[selected]?.props">
                        <div>
                            <template x-for="(value, key) in blocks[selected].props" :key="key">
                                <div class="mb-4">
                                    <template x-if="key === 'background_image'">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Background Image</label>

                                            <!-- Image Preview -->
                                            <div class="mb-2">
                                                <img :src="blocks[selected].props[key] ? '{{ $baseUrl }}/' + blocks[selected].props[key] : 'https://placehold.co/400'" 
                                                    class="img-fluid rounded border" style="max-height: 150px;"
                                                    alt="Preview">
                                            </div>

                                            <!-- Hidden field or just direct model binding -->
                                            <input type="text" class="form-control mb-2" placeholder="Image URL"
                                                x-model="blocks[selected].props[key]">

                                            <!-- Your custom popup trigger -->
                                            {{-- <button type="button" class="btn btn-outline-primary btn-sm"
                                                @click="openImagePicker('background_image')">Choose Image</button> --}}
                                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas"
                                                data-bs-target="#builder-offcanvas" data-type="builder"
                                                :data-key="key" @click="$store.mediaManager.targetKey = key">
                                                Upload File
                                            </button>
                                        </div>
                                    </template>
                                    <!-- If value is an array of objects (like testimonials or faq items) -->
                                    <template x-if="Array.isArray(value) && typeof value[0] === 'object'">
                                        <div>
                                            <label class="form-label fw-bold mb-1" x-text="key"></label>

                                            <template x-for="(item, idx) in value" :key="idx">
                                                <div class="p-3 mb-3 border rounded bg-light">
                                                    <template x-for="(fieldVal, fieldKey) in item" :key="fieldKey">
                                                        <div class="mb-2">
                                                            <label class="form-label" x-text="fieldKey"></label>
                                                            <input type="text" class="form-control"
                                                                x-model="blocks[selected].props[key][idx][fieldKey]">
                                                        </div>
                                                    </template>

                                                    <!-- Remove button -->
                                                    <button type="button" class="btn btn-sm btn-danger mt-2"
                                                        @click="blocks[selected].props[key].splice(idx, 1)">Remove</button>
                                                </div>
                                            </template>

                                            <!-- Add New Item -->
                                            <button type="button" class="btn btn-sm btn-primary mt-2"
                                                @click="blocks[selected].props[key].push(Object.fromEntries(Object.keys(value[0]).map(k => [k, ''])))">
                                                + Add New
                                            </button>
                                        </div>
                                    </template>

                                    <!-- Normal field (not array of objects) -->
                                    <template
                                        x-if="key !== 'background_image' && (!Array.isArray(value) || typeof value[0] !== 'object')">
                                        <div>
                                            <label class="form-label fw-bold mb-1" x-text="key"></label>
                                            <input type="text" class="form-control"
                                                x-model="blocks[selected].props[key]">
                                        </div>
                                    </template>

                                </div>
                            </template>
                        </div>
                    </template>
                </div>
                <!-- Shared Offcanvas -->
                @include('admin.components.media.popup', [
                    'modalId' => 'builder-offcanvas',
                    'inputType' => 'single',
                    'from' => 'builder',
                    // 'imageInputName' => 'media_input'
                ])

                <button @click="save()" class="btn btn-primary w-100">Save</button>
            </div>
        </div>
        <div id="resizer" style="width: 5px; cursor: ew-resize; background: #ccc;"></div>
        <div id="main" style="flex-grow: 1; background: #fff;height: 100vh;">
            <!-- main content -->
            <iframe src="{{ route('frontend.pages.show', $page->slug) }}" width="100%" height="100%"
                style="border: none;"></iframe>
            <!-- Preview -->
            {{-- <div id="preview" class="">
                <template x-for="block in blocks" :key="block.type + Math.random()">
                    <div class="mb-6 border rounded p-4" x-html="renderBlock(block)" x-data=''></div>
                </template>
            </div> --}}
        </div>
    </div>


@endsection


@push('scripts')
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

        document.addEventListener('alpine:init', () => {
            // Alpine data for the builder
            Alpine.data('builder', () => ({
                blocks: [],
                route: '{{ route('admin.pages.builder.store', $page) }}', // adjust if needed
                selected: null,

                init() {
                    this.blocks = JSON.parse(@json($page->builder ?? '[]'));
                },

                selectBlock(index) {
                    this.selected = index;
                },

                // openImagePicker(propKey = 'image') {
                //     if (this.selected === null || !this.blocks[this.selected]) return;

                //     Alpine.store('mediaManager').targetKey = propKey;

                //     const modalId = 'builder-offcanvas';
                //     const modal = document.getElementById(modalId);

                //     if (modal) {
                //         modal.setAttribute('data-route', '{{ route('admin.media.index') }}');
                //         modal.setAttribute('data-type', 'single');
                //         new tabler.bootstrap.Offcanvas(modal).show();
                //     }
                // },

                save() {
                    axios.post(this.route, {
                            builder: this.blocks
                        })
                        .then(() => {
                            const iframe = document.querySelector('iframe');
                            iframe?.contentWindow?.location.reload();

                            setTimeout(() => {
                                const iframeDoc = iframe?.contentDocument || iframe
                                    ?.contentWindow?.document;
                                const blockId = this.blocks[this.selected]?.type + this
                                    .selected;
                                const target = iframeDoc?.getElementById(blockId);

                                if (target) {
                                    target.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'start'
                                    });
                                } else {
                                    console.warn('Element not found:', blockId);
                                }
                            }, 500);
                        })
                        .catch(error => {
                            console.error('Save failed:', error);
                        });
                }
            }));

            // Alpine store for media manager
            Alpine.store('mediaManager', {
                targetKey: null,
                insertImage(url, fullPath) {
                    const builderComponent = document.querySelector('[x-data="builder"]')?._x_dataStack?.[0];
                    if (!builderComponent || builderComponent.selected === null || !this.targetKey) return;

                    const block = builderComponent.blocks[builderComponent.selected];
                    if (!block.props) block.props = {};

                    // Just store the relative path like "storage/images/example.jpg"
                    block.props[this.targetKey] = url;

                    this.targetKey = null;
                }
            });
        });
    </script>
    <script>
        const resizer = document.getElementById('resizer');
        const sidebar = document.getElementById('sidebar');
        const container = document.querySelector('.components');

        let isResizing = false;

        const startResize = (e) => {
            isResizing = true;
            document.body.style.cursor = 'col-resize';

            // Prevent text selection while resizing
            document.body.style.userSelect = 'none';
        };

        const stopResize = () => {
            isResizing = false;
            document.body.style.cursor = '';
            document.body.style.userSelect = '';
        };

        const handleMouseMove = (e) => {
            if (!isResizing) return;

            const containerLeft = container.getBoundingClientRect().left;
            let newWidth = e.clientX - containerLeft;
            newWidth = Math.max(150, Math.min(newWidth, 700));

            sidebar.style.width = newWidth + 'px';
        };

        resizer.addEventListener('mousedown', startResize);
        document.addEventListener('mousemove', handleMouseMove);
        document.addEventListener('mouseup', stopResize);
    </script>
@endpush
