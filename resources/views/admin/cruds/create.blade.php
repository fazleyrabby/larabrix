@extends('admin.layouts.app')
@section('title', 'Crud Create')
@push('styles')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
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
                        Crud
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.cruds.index') }}" class="btn btn-danger">
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
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.cruds.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Create new crud</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Title</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            placeholder="Title" name="title" value="{{ old('title') }}">
                                        <small class="form-hint">
                                            @error('title')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Textarea</label>
                                    <div class="col">
                                        <textarea name="textarea" class="form-control" id="">{{ old('textarea') }}</textarea>
                                        <small class="form-hint">
                                            @error('textarea')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Default File input</label>
                                    <div class="col">
                                        <input type="file" class="form-control" name="default_file_input">
                                        <small class="form-hint">
                                            @error('textarea')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Filepond input</label>
                                    <div class="col">
                                        <input type="file" class="form-control filepond" name="filepond_input" data-pond>
                                        <small class="form-hint">
                                            @error('filepond_input')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Media File Input</label>
                                    <div class="col">
                                        <button type="button" class="btn btn-primary" id="crud-offcanvas-btn"
                                            data-bs-toggle="offcanvas" data-bs-target="#crud-offcanvas"
                                            aria-controls="crud-offcanvas" aria-expanded="false">
                                            Upload File
                                        </button>

                                        <div id="crud-offcanvas-wrapper">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Custom Select</label>
                                    <div class="col">
                                        <select type="text" class="form-select" name="custom_select"
                                            id="select-users" value="">
                                            <option value="1">Chuck Tesla</option>
                                            <option value="2">Elon Musk</option>
                                            <option value="3">Paweł Kuna</option>
                                            <option value="4">Nikola Tesla</option>
                                        </select>
                                        {{-- <input type="file" class="form-control" name="custom_select"> --}}
                                        <small class="form-hint">
                                            @error('custom_select')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="submit" name="action" value="save_and_create"
                                    class="btn btn-success">Save and create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.components.media.popup', [
        'modalId' => 'crud-offcanvas',
        'inputType' => 'single',
        'imageInputName' => 'media_input'
    ])

@endsection

@push('scripts')
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize FilePond
            const inputElement = document.querySelector('.filepond');
            const pond = FilePond.create(inputElement, {
                acceptedFileTypes: ['image/*'],
                server: {
                    process: @json(route('admin.filepond.upload')),
                    revert: @json(route('admin.filepond.revert')),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });

            var el;
            window.TomSelect && (new TomSelect(el = document.getElementById('select-users'), {
                copyClassesToDropdown: false,
                dropdownParent: 'body',
                controlInput: '<input>',
                render: {
                    item: function(data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function(data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            }));
        });
    </script>
@endpush
