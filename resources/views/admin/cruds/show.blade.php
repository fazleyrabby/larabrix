@extends('admin.layouts.app')
@section('title', 'Crud View')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Crud
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ url()->previous() }}" class="btn btn-danger">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
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
                    <div class="card-header">
                        <h3 class="card-title">Crud preview</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Title</label>
                            <div class="col">
                                {{ $crud->title }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Textarea</label>
                            <div class="col">
                                {{ $crud->textarea }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Default File</label>
                            <div class="col">
                                @if($crud->default_file_input)
                                    <img width="100" src="{{ asset('storage/' . $crud->default_file_input) }}" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Filepond File</label>
                            <div class="col">
                                @if($crud->filepond_input)
                                    <img width="100" src="{{ asset('storage/' . $crud->filepond_input) }}" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Media File</label>
                            <div class="col">
                                @if($crud->media_input)
                                    <img width="100" src="{{ asset($crud->media_input) }}" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Select Input</label>
                            <div class="col">
                                {{ $crud->custom_select }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('admin.cruds.edit', $crud->id) }}" class="btn btn-primary">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            Edit
                        </a>
                    </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection
