@extends('admin.layouts.app')
@section('title', 'Form Edit')
@push('styles')
    <style>
        .sortable-ghost {
            opacity: 0.4;
            background: transparent;
            box-shadow: none;
        }

        .sortable-list .field-preview {
            cursor: move;
        }

        .field-preview {
            position: relative;
        }

        .edit-btns {
            opacity: 0;
            position: absolute;
            top: 5px;
            right: 5px;
            transition: opacity 200ms ease;
        }

        .edit-field-btn,
        .remove-field-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
        }

        .edit-field-btn svg,
        .remove-field-btn svg {
            pointer-events: none;
            /* Prevent svg from capturing clicks */
        }

        .field-preview:hover .edit-btns {
            opacity: 1;
        }
    </style>
@endpush
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-fluid">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    {{-- <div class="page-pretitle">
                        Overview
                    </div> --}}
                    <h2 class="page-title">
                        Form Create
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.forms.index') }}" class="btn btn-danger">
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
        <div class="container-fluid">
            <div class="row row-deck row-cards">
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Components</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 components">
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="text"
                                                data-label="Input" data-name="input">Input</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="textarea"
                                                data-label="Textarea" data-name="textarea">Textarea</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="select"
                                                data-label="Select" data-name="select">Select</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="multiselect"
                                                data-label="Multi Select" data-name="multi_select">Multi Select</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="checkbox"
                                                data-label="Checkbox" data-name="checkbox">Checkbox</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="radio"
                                                data-label="Radio Options" data-name="radio">Radio Options</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col text-truncate">
                                            <button class="btn btn-secondary w-100 btn-add-field" data-type="file"
                                                data-label="File Input" data-name="file">File Input</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="card">
                        <form action="{{ route('admin.forms.update', $form->id) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="card-header">
                                <h3 class="card-title">Create new form</h3>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label for="formName" class="form-label">Form Name</label>
                                    <input type="text" class="form-control" id="formName" name="name"
                                        value="{{ $form->name }}" required>
                                </div>

                                <h3>Fields</h3>
                                <div id="fields-preview-wrapper" class="sortable-list">
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="submit" name="edit" value="1" class="btn btn-success">Save and Edit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title" id="offcanvasEndLabel">Edit Field</h2>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="mb-3">
                <label>Label</label>
                <input type="text" class="form-control" id="offcanvas-label">
            </div>
            <div class="mb-3">
                <label>Placeholder</label>
                <input type="text" class="form-control" id="offcanvas-placeholder">
            </div>
            <div class="mb-3">
                <label>Field Name</label>
                <input type="text" class="form-control" id="offcanvas-name">
            </div>
            <div class="mb-3">
                <label>Validation Rules</label>
                <input type="text" class="form-control" id="offcanvas-validation" placeholder="e.g. required,email">
            </div>
            <div class="mb-3 d-none" id="options-container">
                <label class="form-label">Options</label>
                <div id="options-list"></div>
                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="add-option-btn">Add
                    Option</button>
            </div>

            <div class="mt-4">
                {{-- <button class="btn btn-primary w-100" type="button" id="save-offcanvas-btn">Save</button> --}}
                <button class="btn btn-primary" type="button" id="save-offcanvas-btn"
                    data-bs-dismiss="offcanvas">Save</button>
            </div>
        </div>
    </div>
    
<input type="hidden" id="existingFields" value="{{ json_encode($fields) }}">
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js"
        integrity="sha512-csIng5zcB+XpulRUa+ev1zKo7zRNGpEaVfNB9On1no9KYTEY/rLGAEEpvgdw6nim1WdTuihZY1eqZ31K7/fZjw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('admin/dist/js/form-builder.js') }}"></script>
@endpush
