@push('styles')

<style>

    .custom.loader{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 4rem;
        height: 4rem;
    }

</style>

@endpush
<div class="modal media-modal"
    id="{{ $modalId }}"
    data-type="{{ $inputType }}"
    data-route="{{ route('admin.media.index') }}?type=modal&inputType={{ $inputType }}"
    data-image-input="{{ $imageInputName }}">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header">
                    <h5 class="modal-title"><a target="_blank" href="{{ route('admin.media.index') }}">Media Gallery</a></h5>
                    <button class="btn-close" data-modal-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-3 align-items-end">
                    <form class="ajaxform-file-upload mb-3" action="{{ route('admin.media.store') }}" method="post"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="form-group">
                            <input type="file" name="images[]" id="media" multiple />
                        <button class="btn btn-primary" type="submit">Upload</button>
                        </div>
                    </form>
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
