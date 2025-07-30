@php
    $isModal = request()->get('type') == 'modal';
    $folderId = request()->get('parent_id');
@endphp

<style>
    .media-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .media-item {
        width: calc(12.5% - 1rem);

        /* 8 items per row */
        min-width: @if ($isModal)
            120px
        @else
            140px
        @endif
        ;
        background-color: #f8f9fa;
        border-radius: 6px;
        /* overflow: hidden; */
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        position:relative;
    }

    .media-item .context {
        position: absolute;
        top: 5px;
        right: 0;
        padding: 5px;
    }

    .form-imagecheck-figure {
        height: 180px;
    }

    .form-imagecheck-image {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    @media (max-width: 1400px) {
        .media-item {
            width: calc(14.285% - 1rem);
            /* 7 items per row */
        }
    }

    @media (max-width: 1200px) {
        .media-item {
            width: calc(16.666% - 1rem);
            /* 6 items per row */
        }
    }

    @media (max-width: 992px) {
        .media-item {
            width: calc(20% - 1rem);
            /* 5 items per row */
        }
    }

    @media (max-width: 768px) {
        .media-item {
            width: calc(25% - 1rem);
            /* 4 items per row */
        }
    }

    @media (max-width: 576px) {
        .media-item {
            width: 100%;
            /* 1 item per row */
        }
    }
</style>

@if ($folderId)
    @php $parentFolder = \App\Models\MediaFolder::find($folderId); @endphp
    <div class="mb-3 d-flex align-items-center gap-2">
        @if ($isModal)
            <a href="#" class="btn btn-sm btn-secondary folder-link"
                data-url="{{ request()->fullUrlWithQuery(['parent_id' => $parentFolder?->parent_id]) }}">
                ⬅ Back
            </a>
        @else
            <a href="{{ request()->fullUrlWithQuery(['parent_id' => $parentFolder?->parent_id]) }}"
                class="btn btn-sm btn-secondary">
                ⬅ Back
            </a>
        @endif

        <strong>{{ $parentFolder?->name }}</strong>
    </div>
@endif

<form class="delete_form media-container media-flex" action="{{ route('admin.media.delete') }}" method="post">
    @csrf

    {{-- Show folders --}}
    @foreach ($folders as $folder)
        <div class="media-item folder-container p-3 text-center">
            @if ($isModal)
                {{-- In modal: clickable but no page reload (AJAX will handle) --}}
                <a href="#" class="folder-link d-block text-decoration-none text-dark"
                    data-folder-id="{{ $folder->id }}"
                    data-url="{{ route('admin.media.index') }}?type=modal&parent_id={{ $folder->id }}">
                    <div class="folder-icon" style="font-size: 48px;">📁</div>
                    <div class="folder-name mt-2 text-truncate" title="{{ $folder->name }}">
                        {{ $folder->name }}
                    </div>
                </a>
            @else
                {{-- Normal page: regular link --}}
                <a href="{{ request()->fullUrlWithQuery(['parent_id' => $folder->id]) }}"
                    class="d-block text-decoration-none text-dark">
                    <div class="folder-icon" style="font-size: 48px;">📁</div>
                    <div class="folder-name mt-2 text-truncate" title="{{ $folder->name }}">
                        {{ $folder->name }}
                    </div>
                </a>
            @endif
            <div class="dropdown context">
                <a href="#" class="btn-action dropdown-toggle p-1" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><!-- Download SVG icon from http://tabler.io/icons/icon/dots-vertical -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-1">
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></a>
                <div class="dropdown-menu dropdown-menu-end">
                    {{-- <button type="button" class="dropdown-item" id="folder-context-modal-btn"
                        data-id="{{ $folder->id }}">Move to</button> --}}
                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                        data-bs-target="#folder-context-{{ $folder->id }}"
                        id="folder-context-{{ $folder->id }}-btn">
                        Move to
                    </button>
                    <a class="dropdown-item text-danger delete-folder" href="#" data-url="{{ route('admin.media.folder.delete', $folder->id) }}" data-id="{{ $folder->id }}">Delete</a>
                </div>
            </div>
        </div>
        @php $folders = \App\Models\MediaFolder::toBase()->whereNot('id', $folder->id)->select('name', 'id','parent_id')->get(); @endphp
        <x-modal id="folder-context-{{ $folder->id }}" title="Move {{ $folder->name }} to"
            backdrop="{{ $isModal ? 'false' : 'true' }}" showFooter="false">
            <label for="folder_id">Select folder</label>
            <select name="folder_id" class="form-control mb-3">
                @if(!empty($folder->parent_id))
                    <option value="">/</option>
                @endif
                @foreach ($folders as $id => $item)
                    <option value="{{ $item->id }}" @selected($item->id == $folder->parent_id)>{{ $item->name }}</option>
                @endforeach
            </select>
            <input name="is_file" type="hidden" value="false">
            <input type="hidden" value="{{ $folder->id }}" name="id">
            <button type="button" class="btn btn-primary move-folder">Save</button>
        </x-modal>
    @endforeach



    {{-- Show media items (same for modal and normal) --}}
    @foreach ($media as $item)
        <div class="media-item image-container">
            <label class="form-imagecheck position-relative d-block w-100 h-100">
                <input name="ids[]" type="checkbox" value="{{ $item->id }}"
                    class="form-imagecheck-input position-absolute top-0 start-0 z-2" data-url="{{ $item->url }}"
                    data-fullpath="{{ Storage::disk('public')->url($item->url) }}" />
                <span class="form-imagecheck-figure d-block w-100">
                    <img src="{{ Storage::disk('public')->url($item->url) }}" alt="Media Item"
                        class="form-imagecheck-image" />
                </span>
            </label>
            
              <div class="dropdown context">
                <a href="#" class="btn-action dropdown-toggle p-1" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><!-- Download SVG icon from http://tabler.io/icons/icon/dots-vertical -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-1">
                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg></a>
                <div class="dropdown-menu dropdown-menu-end">
                    {{-- <button type="button" class="dropdown-item" id="folder-context-modal-btn"
                        data-id="{{ $folder->id }}">Move to</button> --}}
                    @if (!$isModal)
                    <button type="button" class="dropdown-item view" 
                            data-created-at="{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('LLL') }}"
                            data-preview-url="{{ Storage::disk('public')->url($item->url) }}" data-url="{{ $item->url }}">
                            View
                    </button>
                    @endif
                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                        data-bs-target="#file-context-{{ $item->id }}"
                        id="file-context-{{ $item->id }}-btn">
                        Move to
                    </button>
                    <a class="dropdown-item text-danger" href="#">Delete</a>
                </div>
            </div>
        </div>
        
        @php $folders = \App\Models\MediaFolder::toBase()->whereNot('id', $item->folder_id)->select('name', 'id','parent_id')->get(); @endphp
        <x-modal id="file-context-{{ $item->id }}" title="Move {{ $item->url }} to"
            backdrop="{{ $isModal ? 'false' : 'true' }}" showFooter="false">
            <label for="folder_id">Select folder</label>
            <select name="folder_id" class="form-control mb-3">
                @if(!empty($item->folder_id))
                    <option value="">/</option>
                @endif
                @foreach ($folders as $id => $folder)
                    <option value="{{ $folder->id }}" @selected($folder->id == $item->folder_id)>{{ $folder->name }}</option>
                @endforeach
            </select>
            <input type="hidden" value="{{ $item->id }}" name="id">
            <input name="is_file" type="hidden" value="true">
            <button type="button" class="btn btn-primary move-folder">Save</button>
        </x-modal>
    @endforeach
</form>

