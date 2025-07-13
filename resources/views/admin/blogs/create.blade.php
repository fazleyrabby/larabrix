@extends('admin.layouts.app')
@section('title', 'Blog Create')
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
                        Blog
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.products.categories.index') }}" class="btn btn-danger">
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
                <form action="{{ route('admin.blogs.store') }}" method="post">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Create new blog</h3>
                    </div>
                   <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Title</label>
                                <div class="col">
                                    <input type="text" class="form-control"
                                        placeholder="Title" name="title" value="{{ old('title') }}">
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
                                    <input type="text" class="form-control"
                                        placeholder="slug" name="slug" value="{{ old('slug') }}">
                                    <small class="form-hint">
                                        @error('slug')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Body</label>
                                <div class="col">
                                    <textarea id="hugerte-mytextarea" name="body">{{ old('body') }}</textarea>
                                    <small class="form-hint">
                                        @error('body')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Tags</label>
                                <div class="col">
                                    <select name="tags[]" id="tags" multiple class="form-control">
                                        @foreach ($tags as $id => $tag)
                                            <option value="{{ $id }}" @selected(in_array($id, old('tags', [])))>
                                                {{ $tag }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-hint">
                                        @error('tag_id')
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
<script src="{{ asset('admin/dist/libs/hugerte/hugerte.min.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    let el;
    if (window.TomSelect) {
        new TomSelect(el = document.getElementById('tags'), {
            allowEmptyOption: true,
            create: true
        });
    }
    let options = {
        selector: "#hugerte-mytextarea",
        height: 600,
        menubar: true,
        statusbar: true,
        license_key: "gpl",
        plugins: [
        "fullscreen",
        "advlist",
        "autolink",
        "lists",
        "link",
        "image",
        "charmap",
        "preview",
        "anchor",
        "searchreplace",
        "visualblocks",
        "code",
        "fullscreen",
        "insertdatetime",
        "media",
        "table",
        "code",
        "help",
        "wordcount",
        "codesample",
        "markdown",
        ],
        toolbar:
        "undo redo | formatselect |" +
        "bold italic backcolor | alignleft aligncenter" +
        "alignright alignjustify | bullist numlist outdent indent |" +
        "code codesample removeformat markdown help fullscreen",
        content_style:
        "body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }",
    };
    if (localStorage.getItem("tablerTheme") === "dark") {
        options.skin = "oxide-dark";
        options.content_css = "dark";
    }
        hugeRTE.init(options);
    });
</script>
@endpush
