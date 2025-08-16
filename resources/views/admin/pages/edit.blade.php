@extends('admin.layouts.app')
@section('title', 'Page Edit')
@push('styles')
    {{-- <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css"> --}}
    <style>
        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content table,
        .content th,
        .content td {
            border: 1px solid #dee2e6;
        }

        .content th {
            background-color: #f8f9fa;
        }

        .content>div {
            padding: 1rem;
        }

        .drag-handle {
        cursor: grab;
        display: inline-block;
        width: 16px;
        height: 16px;
        margin-right: 6px;
        vertical-align: middle;
        background: #ccc; /* or dots: background: repeating-linear-gradient(90deg, #000 0 2px, transparent 2px 4px); */
        border-radius: 2px;
        }
    </style>
@endpush
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    {{-- <div class="page-pretitle">
                        Overview
                    </div> --}}
                    <h2 class="page-title">
                        Page
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="page-body">
        <form id="pageForm" action="{{ route('admin.pages.update', $page->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="container-xl">
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="space-y">
                                    <div>
                                        <label class="form-label"> Title </label>
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            placeholder="Title" name="title" value="{{ $page->title }}">
                                        <small class="form-hint">
                                            @error('title')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                    <div>
                                        <label class="form-label"> Slug </label>
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            placeholder="Slug" name="slug" value="{{ $page->slug }}">
                                        <small class="form-hint">
                                            @error('slug')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                    <div>
                                        <label for="content">Content</label>
                                        <div class="editor-toolbar mb-2" style="display: flex;gap: 5px; flex-wrap: wrap;">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="bold">Bold</button>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="italic">Italic</button>
                                            <button type="button" class="btn btn-sm btn-primary" data-command="heading"
                                                data-level="1">H1</button>
                                            <button type="button" class="btn btn-sm btn-primary" data-command="heading"
                                                data-level="2">H2</button>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="bulletList">UL</button>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="orderedList">OL</button>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="blockquote">Quote</button>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="codeblock">Code</button>

                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="insertTable">Table 2x2</button>
                                            <button type="button" class="btn btn-sm btn-primary" data-command="addRow">Add
                                                Row</button>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="addColumn">Add Column</button>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="deleteRow">Delete Row</button>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="deleteColumn">Delete Column</button>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="deleteTable">Delete Table</button>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="youtube">Youtube</button>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-command="drag">Drag Handle</button>
                                        </div>

                                        <div class="editor-content content border" style="min-height:200px;"></div>
                                        <input type="hidden" name="content" id="contentInput">
                                    </div>
                                    {{-- <div>
                                        <textarea id="content" name="content">{{ old('content', $page->content) }}</textarea>
                                        <small class="form-hint">
                                            @error('slug')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row row-cards">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex space-x-1">
                                            @if ($page->has_page_builder)
                                                <a type="button" class="btn btn-dark w-100"
                                                    href="{{ route('admin.pages.builder', ['page' => $page->id]) }}"
                                                    target="_blank">Live View</a>
                                            @endif
                                            <a href="{{ route('frontend.pages.show', $page->slug) }}"
                                                class="btn btn-outline-dark w-100">Visit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label class="form-check form-switch form-switch-3">
                                            <input class="form-check-input" name="status" type="checkbox"
                                                @checked($page->status == 1)>
                                            <span class="form-check-label">Active</span>
                                        </label>
                                        <label class="form-check form-switch form-switch-3">
                                            <input class="form-check-input" type="checkbox" name="has_page_builder"
                                                @checked($page->has_page_builder == 1)>
                                            <span class="form-check-label">Page Builder</span>
                                        </label>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="submit" name="save" value="save"
                                            class="btn btn-success">Save & Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
    <script>
        const easyMDE = new EasyMDE({element: document.getElementById('content')});
    </script> --}}

    <script type="module">
        import {
            Editor
        } from 'https://esm.sh/@tiptap/core'
        import StarterKit from 'https://esm.sh/@tiptap/starter-kit'
        import Link from 'https://esm.sh/@tiptap/extension-link'
        import Image from 'https://esm.sh/@tiptap/extension-image'
        import Placeholder from 'https://esm.sh/@tiptap/extension-placeholder'
        import CodeBlock from 'https://esm.sh/@tiptap/extension-code-block'
        import {
            Table
        } from 'https://esm.sh/@tiptap/extension-table'
        import {
            TableRow
        } from 'https://esm.sh/@tiptap/extension-table-row'
        import {
            TableHeader
        } from 'https://esm.sh/@tiptap/extension-table-header'
        import {
            TableCell
        } from 'https://esm.sh/@tiptap/extension-table-cell'
        import {
            Youtube
        } from 'https://esm.sh/@tiptap/extension-youtube'
        import DragHandle from 'https://esm.sh/@tiptap/extension-drag-handle'

        const editor = new Editor({
            element: document.querySelector('.content'),
            extensions: [
                StarterKit.configure({
                    heading: {
                        levels: [1, 2, 3]
                    },
                    paragraph: {
                        draggable: true
                    }, // make paragraphs draggable
                    blockquote: {
                        draggable: true
                    }, // blockquotes draggable
                    horizontalRule: {
                        draggable: true
                    },
                    bulletList: {
                        draggable: true
                    },
                    orderedList: {
                        draggable: true
                    },
                    listItem: {
                        draggable: true
                    },
                }),
                Link,
                Image.configure({
                    draggable: true
                }),
                Placeholder.configure({
                    placeholder: 'Start typing...'
                }),
                CodeBlock.configure({
                    draggable: true
                }),
                Table.configure({
                    resizable: true,
                    draggable: true
                }),
                TableRow.configure({
                    draggable: true
                }),
                TableHeader.configure({
                    draggable: true
                }),
                TableCell.configure({
                    draggable: true
                }),
                Youtube.configure({
                    width: 480,
                    draggable: true
                }),
                DragHandle.configure({
                    handle: '.drag-handle', // All elements with this class become drag handles
                    tippyOptions: { placement: 'left' }
                }),
            ],
            content: {!! json_encode($page->content) !!},
        })

        // Add drag-handle spans to all block nodes automatically
        editor.on('create', addDragHandles)
        editor.on('update', addDragHandles)

        function addDragHandles() {
        editor.state.doc.descendants((node, pos) => {
            if (node.type.isBlock) {
            const dom = editor.view.domAtPos(pos).node
            if (dom && !dom.querySelector('.drag-handle')) {
                const span = document.createElement('span')
                span.className = 'drag-handle'
                dom.insertBefore(span, dom.firstChild)
            }
            }
        })
        }


        document.getElementById('pageForm').addEventListener('submit', () => {
            document.getElementById('contentInput').value = editor.getHTML()
        })

        // Toolbar buttons
        document.querySelectorAll('.editor-toolbar [data-command]').forEach(button => {
            button.addEventListener('click', () => {
                const command = button.dataset.command
                switch (command) {
                    case 'bold':
                        editor.chain().focus().toggleBold().run();
                        break;
                    case 'italic':
                        editor.chain().focus().toggleItalic().run();
                        break;
                    case 'heading':
                        editor.chain().focus().toggleHeading({
                            level: parseInt(button.dataset.level)
                        }).run();
                        break;
                    case 'bulletList':
                        editor.chain().focus().toggleBulletList().run();
                        break;
                    case 'orderedList':
                        editor.chain().focus().toggleOrderedList().run();
                        break;
                    case 'blockquote':
                        editor.chain().focus().toggleBlockquote().run();
                        break;
                    case 'codeblock':
                        editor.chain().focus().toggleCodeBlock().run();
                        break;

                    case 'insertTable':
                        editor.chain().focus().insertTable({
                            rows: 2,
                            cols: 2,
                            withHeaderRow: true
                        }).run();
                        break;
                    case 'addRow':
                        editor.chain().focus().addRowAfter().run();
                        break;
                    case 'addColumn':
                        editor.chain().focus().addColumnAfter().run();
                        break;
                    case 'deleteRow':
                        editor.chain().focus().deleteRow().run();
                        break;
                    case 'deleteColumn':
                        editor.chain().focus().deleteColumn().run();
                        break;
                    case 'deleteTable':
                        editor.chain().focus().deleteTable().run();
                        break;
                    case 'deleteTable':
                        editor.commands.unlockDragHandle();
                        break;
                    case 'youtube':
                        editor.commands.setYoutubeVideo({
                            src: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                            width: 640,
                            height: 480,
                        })
                        break;
                }
            })
        })
    </script>
@endpush
