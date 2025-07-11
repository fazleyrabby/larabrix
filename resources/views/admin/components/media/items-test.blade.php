@php $isModal = request()->get('type') == 'modal'; @endphp
<div class="d-flex">
    <div style="width: 200px; border-right: 1px solid #ccc; padding: 10px;">
        <div class="mb-3">
            <button type="button" class="btn btn-sm btn-secondary" onclick="goBack()">⬅ Go Back</button>
        </div>
        <div id="folder-tree"></div>
        {{-- Create Folder UI --}}
        <input type="text" id="new-folder-name" class="form-control form-control-sm mb-2" placeholder="New folder name">
        <button type="button" class="btn btn-sm btn-success w-100" onclick="createFolder()">Create Folder</button>
    </div>
    <div style="flex-grow: 1; padding: 10px;">
        <form class="delete_form media-container row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2"
            action="{{ route('admin.media.delete') }}" method="post">
            @csrf
            <input type="hidden" name="folder_name" id="folder-name">
            @foreach ($media as $index => $item)
                <div class="col image-container">
                    <label class="form-imagecheck d-block position-relative w-100 h-100">
                        <input name="ids[]" type="checkbox" value="{{ $item->id }}"
                            class="form-imagecheck-input position-absolute top-0 start-0 z-2"
                            data-url="{{ $item->url }}"
                            data-fullpath="{{ Storage::disk('public')->url($item->url) }}" />
                        <span class="form-imagecheck-figure d-block overflow-hidden rounded shadow-sm w-100 h-100">
                            <img src="{{ Storage::disk('public')->url($item->url) }}" alt="Media Item"
                                class="form-imagecheck-image w-100 h-100 object-fit-cover" style="max-height: 240px;" />
                        </span>
                    </label>

                    @if (!$isModal)
                        <span class="view btn btn-sm btn-primary mt-2"
                            data-created-at="{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('LLL') }}"
                            data-preview-url="{{ Storage::disk('public')->url($item->url) }}"
                            data-url="{{ $item->url }}">
                            View
                        </span>
                    @endif
                </div>
            @endforeach
        </form>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                window.currentFolder = '';
                window.parentFolder = '';

                window.createFolder = function() {
                    const input = document.getElementById('new-folder-name');
                    const folderName = input.value.trim();
                    if (!folderName) return alert('Please enter a folder name.');

                    const fullPath = window.currentFolder ? `${window.currentFolder}/${folderName}` : folderName;

                    axios.post('/admin/media/create-folder', {
                        folder: fullPath.replace(/\/+/g, '/') // clean up slashes
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    }).then(() => {
                        input.value = '';
                        window.loadFolderTree();
                        window.fetchMedia(window.currentFolder);
                    }).catch(err => {
                        alert('Failed to create folder');
                        console.error(err);
                    });
                };

                window.fetchMedia = function(folder = '') {
                    document.getElementById('folder-name').value = folder;

                    axios.get('/admin/media/browse', {
                            params: {
                                folder
                            }
                        })
                        .then(res => {
                            const data = res.data;
                            window.currentFolder = data.current_folder;
                            window.parentFolder = data.parent_folder;

                            const container = document.querySelector('.media-container');
                            if (!container) return;

                            let html = '';
                            data?.folders?.forEach(f => {
                                const name = f.split('/').pop();
                                html += `<div class="col">
                                    <div class="p-2 border rounded bg-light mb-2" style="cursor:pointer" onclick="fetchMedia('${f.replace(/^media\//, '')}')">
                                        📁 ${name}/
                                    </div>
                                </div>`;
                            });

                            data?.files?.forEach(f => {
                                const name = f.split('/').pop();
                                // const url = '/storage/' + f.replace(/^media\//, '');
                                const url = f;
                                const filePath = @json(Storage::disk('public')->url('')) + f;


                                html += `<div class="col image-container">
                                    <label class="form-imagecheck d-block position-relative w-100 h-100">
                                        <input name="ids[]" type="checkbox" value="${url}"
                                            class="form-imagecheck-input position-absolute top-0 start-0 z-2"
                                            data-url="${url}"
                                            data-fullpath="${filePath}" />
                                        <span class="form-imagecheck-figure d-block overflow-hidden rounded shadow-sm w-100 h-100">
                                            <img src="${filePath}" alt="${name}"
                                                class="form-imagecheck-image w-100 h-100 object-fit-cover" style="max-height: 240px;" />
                                        </span>
                                    </label>

                                    <span class="view btn btn-sm btn-primary mt-2"
                                        data-created-at=""
                                        data-preview-url="${filePath}"
                                        data-url="${url}">
                                        View
                                    </span>
                                </div>`;
                            });

                            container.innerHTML = html;
                        })
                        .catch(err => {
                            console.error('Failed to fetch media:', err);
                        });
                }
                window.goBack = function() {
                    if (!window.parentFolder) return;
                    window.fetchMedia(window.parentFolder);
                };

                window.selectImage = function(path) {
                    const hiddenInput = document.getElementById('selected_image');
                    if (hiddenInput) {
                        hiddenInput.value = path;
                        alert(`Selected: ${path}`);
                    }
                };

                window.loadFolderTree = function() {
                    axios.get('/admin/media/folder-tree')
                        .then(res => {
                            const html = buildTreeHTML(res.data.tree);
                            document.getElementById('folder-tree').innerHTML = html;
                        }).catch(err => {
                            console.error('Failed to load folder tree:', err);
                        });
                };

                function buildTreeHTML(tree) {
                    let html = '<ul style="padding-left: 15px;">';
                    tree?.forEach(folder => {
                        html += `<li>
                            <span onclick="fetchMedia('${folder.full_path}')" style="cursor:pointer;">📁 ${folder.name}</span>
                            ${folder.children.length ? buildTreeHTML(folder.children) : ''}
                        </li>`;
                    });
                    html += '</ul>';
                    return html;
                }

                // Initial load
                window.loadFolderTree();
                window.fetchMedia();
            });
        </script>
    @endpush
@endonce
