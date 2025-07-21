@extends('admin.layouts.app')
@section('title', 'Crud Create')
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
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
                        Pages
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
    <div class="page-body">
        <form action="{{ route('admin.pages.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container-xl">
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="space-y">
                                    <div>
                                        <label class="form-label"> Title </label>
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            placeholder="Title" name="title" value="{{ old('title') }}">
                                        <small class="form-hint">
                                            @error('title')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                    <div>
                                        <label class="form-label"> Slug </label>
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            placeholder="slug" name="slug" value="{{ old('slug') }}">
                                        <small class="form-hint">
                                            @error('slug')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </small>
                                    </div>
                                    <div>
                                        <textarea id="content" name="content">{{ old('content') }}</textarea>
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
                    <div class="col-4">
                        <div class="row row-cards">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex space-x-1">
                                            <button type="button" class="btn btn-dark w-100">Live View</button>
                                            <button type="button" class="btn btn-outline-dark w-100">Visit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label class="form-check form-switch form-switch-3">
                                            <input class="form-check-input" type="checkbox" name="status" checked="">
                                            <span class="form-check-label">Active</span>
                                        </label>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary w-100">Submit</button>
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
    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
    <script>
        const easyMDE = new EasyMDE({element: document.getElementById('content')});
    </script>
@endpush
