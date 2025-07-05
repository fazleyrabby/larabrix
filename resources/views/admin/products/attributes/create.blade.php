@extends('admin.layouts.app')
@section('title', 'Attribute Create')
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
                        Attributes
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.products.attributes.index') }}" class="btn btn-danger">
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
        <form action="{{ route('admin.products.attributes.store') }}" method="post">
            @csrf
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create new Attribute</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Title</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            placeholder="Attribute title" name="title" value="{{ old('title') }}">
                                        <small class="form-hint">
                                            @error('title')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Slug</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby=""
                                            placeholder="Attribute Slug" name="slug" value="{{ old('slug') }}">
                                        <small class="form-hint">
                                            @error('slug')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create Attribute Values</h3>
                            </div>
                            <div class="card-body">
                                @if (session('errors'))
                                    <div class="alert alert-danger">
                                        One or more attribute values are invalid.
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="attribute-values-wrapper">
                                </div>
                                <button type="button" class="btn btn-dark" id="add-new">Add New</button>
                            </div>

                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection


@push('scripts')
<script>
    let newIndex = 0;

    document.getElementById('add-new').addEventListener('click', function () {
        const wrapper = document.getElementById('attribute-values-wrapper');

        const row = document.createElement('div');
        row.classList.add('row', 'attribute-value-row');

        row.innerHTML = `
            <div class="col-md-5 mb-3">
                <input type="text" name="values[new_${newIndex}][title]" class="form-control" placeholder="Title">
            </div>
            <div class="col-md-5 mb-3">
                <input type="text" name="values[new_${newIndex}][slug]" class="form-control" placeholder="Slug">
            </div>
            <div class="col-md-2 mb-3">
                <button type="button" class="btn btn-danger remove-row">Remove</button>
            </div>
        `;

        wrapper.appendChild(row);
        newIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-row')) {
            e.target.closest('.attribute-value-row').remove();
        }
    });
</script>
@endpush
