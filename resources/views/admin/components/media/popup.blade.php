@php
    $modalId = $modalId ?? 'mediaModal';
    $inputType = $inputType ?? 'single';
    $imageInputName = $imageInputName ?? 'media_input';
    $from = $from ?? 'form';
@endphp
@push('styles')
<style>
    .custom.loader {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 4rem;
        height: 4rem;
    }
    .custom-offcanvas {
        --tblr-offcanvas-width: 75vw;
    }
</style>
@endpush

<div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="{{ $modalId }}" aria-labelledby="{{ $modalId }}Label" 
     data-type="{{ $inputType }}"
     data-from="{{ $from }}"
     data-route="{{ route('admin.media.index') }}?type=modal&inputType={{ $inputType }}"
     data-image-input="{{ $imageInputName }}">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="{{ $modalId }}Label">
            <a target="_blank" href="{{ route('admin.media.index') }}">Media Gallery</a>
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-0 d-flex flex-column">
        <div class="row mb-3 align-items-end px-3 pt-3">
            <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                {{-- Upload Form --}}
                <form class="ajaxform-file-upload d-flex align-items-center gap-2" 
                      action="{{ route('admin.media.store') }}" method="post" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="file" name="images[]" id="media" multiple class="form-control">
                    <input type="hidden" name="parent_id" id="media-folder-id-{{ $modalId }}"
                           value="{{ request()->parent_id }}">
                    <button class="btn btn-primary" type="submit">Upload</button>
                </form>

                {{-- Add Folder Form --}}
                <form class="add-folder d-flex align-items-center gap-2 ajax-form"
                      action="{{ route('admin.media.store.folder') }}" method="post"
                      data-refresh-url="{{ route('admin.media.index', ['parent_id' => request()->parent_id, 'type' => 'modal']) }}" 
                      data-refresh-target="#ajax-container-{{ $modalId }}">
                    @csrf
                    <input type="text" name="name" class="form-control" placeholder="Folder name">
                    <input type="hidden" name="parent_id" id="media-folder-folder-id-{{ $modalId }}"
                           value="{{ request()->parent_id }}">
                    <button class="btn btn-success" id="add-folder" type="submit">Add Folder</button>
                </form>
            </div>
        </div>

        <div class="position-relative flex-grow-1 px-3">
            <div class="loader custom" style="display: none"></div>
            <div class="row gutters-sm" id="ajax-container-{{ $modalId }}">
                {{-- Content loaded dynamically --}}
            </div>
        </div>

        <div class="preview px-3 mt-3">
            {{-- Image previews etc --}}
        </div>

        <div class="d-flex justify-content-center gap-2 mt-3 px-3" id="pagination-{{ $modalId }}"></div>

        <div class="offcanvas-footer bg-whitesmoke br p-3 mt-auto d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Close</button>
            <button type="button" class="btn btn-primary"  data-bs-dismiss="offcanvas" id="save-media-{{ $modalId }}">Save</button>
        </div>
    </div>
</div>


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    window.success = function(response, url, container, form=null) {
        const folderInput = form.querySelector('input[name="parent_id"]');
        const folderId = folderInput?.value;
        const target = document.querySelector(".media-container");

        folderId ? loadData(`${url}&parent_id=${folderId}`, container, target) : loadData(url, container, target);

        // Clear folder name input
        const nameInput = form.querySelector('input[name="name"]');
        if (nameInput) nameInput.value = "";
    };
});
</script>
@endpush