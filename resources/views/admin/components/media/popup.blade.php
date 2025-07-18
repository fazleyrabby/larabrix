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
    </style>
@endpush
<div class="modal media-modal" id="{{ $modalId }}" data-type="{{ $inputType }}"
    data-route="{{ route('admin.media.index') }}?type=modal&inputType={{ $inputType }}"
    data-image-input="{{ $imageInputName }}">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header">
                    <h5 class="modal-title"><a target="_blank" href="{{ route('admin.media.index') }}">Media Gallery</a>
                    </h5>
                    <button class="btn-close" data-modal-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-3 align-items-end">
                    <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                        {{-- Upload Form --}}
                        <form class="ajaxform-file-upload d-flex align-items-center gap-2"
                            action="{{ route('admin.media.store') }}" method="post" enctype="multipart/form-data"
                            novalidate>
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
                            data-refresh-target="#ajax-container-{{ $modalId }}"
                            >
                            @csrf
                            <input type="text" name="name" class="form-control" placeholder="Folder name">
                            <input type="hidden" name="parent_id" id="media-folder-folder-id-{{ $modalId }}"
                                value="{{ request()->parent_id }}">
                            <button class="btn btn-success" id="add-folder" type="submit">Add Folder</button>
                        </form>
                    </div>
                    <div>
                        <div class="loader custom"></div>
                        <div class="row gutters-sm" id="ajax-container-{{ $modalId }}">
                        </div>
                    </div>
                    <div class="preview">

                    </div>
                </div>
                <div>
                    {{-- <button id="load-more-{{ $modalId }}" class="btn btn-primary">Load More</button> --}}
                    <div id="pagination-{{ $modalId }}" class="d-flex justify-content-center gap-2 mt-3"></div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-modal-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-media-{{ $modalId }}">Save</button>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
function success(response, url, container) {
    let folderId = document.getElementById("media-folder-folder-id-{{ $modalId }}").value;
    folderId = folderId || document.getElementById("media-folder-id-{{ $modalId }}").value;
    console.log(folderId)
    const target = document.querySelector(".media-container");
    loadData(`${url}&parent_id=${folderId}`, container, target)
    document.querySelector('input[name="name"]').value = ""
}
</script>
    
@endpush