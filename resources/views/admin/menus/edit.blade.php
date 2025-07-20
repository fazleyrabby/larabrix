@extends('admin.layouts.app')
@section('title', 'Crud Create')
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
                        Menu
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.menus.index',['type'=> $menu->type]) }}" class="btn btn-danger">
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
                <form action="{{ route('admin.menus.update', $menu->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" name="type" value="{{ $menu->type }}">
                    <div class="card-header">
                        <h3 class="card-title">Update menu</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Title</label>
                            <div class="col">
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                    placeholder="Title" name="title" value="{{ $menu->title }}">
                                <small class="form-hint">
                                    @error('title')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Text</label>
                            <div class="col">
                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                    placeholder="Text" name="text" value="{{ $menu->text }}">
                                <small class="form-hint">
                                    @error('text')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Href</label>
                            <div class="col">
                                <input type="href" class="form-control" aria-describedby="emailHelp"
                                    placeholder="Href" name="href" value="{{ $menu->href }}">
                                <small class="form-hint">
                                    @error('href')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Slug</label>
                            <div class="col">
                                <input type="slug" class="form-control" aria-describedby="emailHelp"
                                    placeholder="Slug" name="slug" value="{{ $menu->slug }}">
                                <small class="form-hint">
                                    @error('slug')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Parent</label>
                            <div class="col">
                                <select type="text" class="form-select" name="parent_id" id="select-users" value="">
                                    <option selected value="0">-</option>
                                    @foreach ($menus as $index => $title)
                                        <option value="{{ $index }}" @selected($index == $menu->parent_id)>{{ $title }}</option>
                                    @endforeach
                                  </select>
                                <small class="form-hint">
                                    @error('parent_id')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection

@push('scripts')
@endpush
