@extends('admin.layouts.app')
@section('title', 'Media')
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
                        Media
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        {{-- <a href="{{ route('admin.cruds.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new crud
                        </a> --}}
                        {{-- <button data-route="{{ route('admin.cruds.bulk_delete') }}" type="button" id="bulk-delete-btn" class="btn btn-danger" disabled>Delete Selected</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-fluid">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body border-bottom py-3 mb-2">
                            <div class="d-flex">
                                <div class="text-secondary">
                                    Show
                                    <div class="mx-2 d-inline-block">
                                        <select name="limit" onchange="updateData(this)"
                                            data-route="{{ route('admin.media.index') }}">
                                            <option value="5" @selected((request()->limit ?? 10) == 5)>5</option>
                                            <option value="10" @selected((request()->limit ?? 10) == 10)>10</option>
                                            <option value="20" @selected((request()->limit ?? 10) == 20)>20</option>
                                        </select>
                                    </div>
                                    items
                                </div>
                                <div class="ms-auto text-secondary">
                                    Search:
                                    <div class="ms-2 d-inline-block">
                                        <form action="">
                                            <input type="text" class="form-control form-control-sm"
                                                aria-label="Search cruds" name="q" value="{{ request()->q }}">
                                            <input type="hidden" name="limit" id="limitInput"
                                                value="{{ request()->limit }}">
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="container-fluid">
                            <div class="row row-deck row-cards">
                                <div class="com-md-12">
                                     <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                                        <form class="ajax-form" action="{{ route('admin.media.store') }}" method="post"
                                        enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <input type="file" name="images[]" id="media" multiple />
                                        <input type="hidden" name="parent_id" value="{{ request()->parent_id }}">
                                        <button class="btn btn-primary ajax-btn" type="submit">Upload</button>
                                        </form>
                                        <button type="button" class="btn btn-danger delete-btn" style="display: none">Delete
                                        </button>
                                        <form class="d-flex align-items-center gap-2 ajax-form" action="{{ route('admin.media.store.folder') }}" method="post">
                                            @csrf
                                            <input type="text" name="name" class="form-control">
                                            <input type="hidden" name="parent_id" value="{{ request()->parent_id }}">
                                            <button class="btn btn-success" id="add-folder" type="submit">Add Folder</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3" id="ajax-container">
                                            @include('admin.components.media.items', ['media' => $media])
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-4">
                                        <div class="preview mb-3">
                                            <img class="preview-img" src="https://placehold.co/600x400">
                                        </div>
                                        <div class="image-info">
                                            <p>No data found!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            {{ $media->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('admin/dist/libs/fslightbox/index.js') }}" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('change', function(e){
            if(!e.target.classList.contains('form-imagecheck-input')) return;
            const checkedInputs = document.querySelectorAll('.form-imagecheck-input:checked');
            if(checkedInputs.length > 0){
                document.querySelector('.delete-btn').style.display = 'block'
            }else{
                document.querySelector('.delete-btn').style.display = 'none'
            }
        })
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('delete-btn')) {
                const checkedInputs = document.querySelectorAll('.form-imagecheck-input:checked');

                if (checkedInputs.length === 0) {
                    toast('error', 'No image selected!');
                    return;
                }
                const deleteForm = document.querySelector('form.delete_form');
                if (deleteForm) {
                    confirmDelete(e, deleteForm); // manually trigger confirmation
                }
            }
            if (e.target.closest('.btn-copy')) {
                const input = document.querySelector('.copy-url');
                if (input) {
                    input.select();
                    document.execCommand('copy');

                    // Optional: show a toast or visual feedback
                    toast('success', 'Copied to clipboard!');
                }
            }
            if (e.target.classList.contains('view')) {
                const viewBtn = e.target;
                const previewUrl = viewBtn.dataset.previewUrl;
                const url = viewBtn.dataset.url;
                const createdAt = viewBtn.dataset.createdAt;

                const html = `
                    <div class='mb-2'>
                        <div class="input-group">
                            <input type="text" class="copy-url form-control" value="${url}">
                            <div class="input-group-append btn-copy cursor-pointer">
                                <div class="input-group-text">
                                    Copy
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        Created At: ${createdAt}
                    </div>
                `;

                document.querySelector('.preview-img').setAttribute('src', previewUrl);
                document.querySelector('.image-info').innerHTML = html;
            }

        });
    });

    function success(response, refresh) {
        let url = window.location.href;
        const target = document.querySelector(".media-container");
        const container = document.getElementById("ajax-container");
        loadData(url, container, target)
        document.querySelector('.ajax-form').reset()
    }

</script>
@endpush
