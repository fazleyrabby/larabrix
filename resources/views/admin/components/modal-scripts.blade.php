@push('scripts')
    <script>
        "use strict";
        document.addEventListener("DOMContentLoaded", () => {
            let currentModalId = null;
            let currentUrl = null;

            // Open modal
            // document.body.addEventListener('click', e => {
            //     const button = e.target.closest('[data-modal-toggle]');
            //     if (!button) return;

            //     console.log(button);
            //     const modalId = button.getAttribute('data-modal-toggle');
            //     const modal = document.getElementById(modalId);
            //     if (!modal) return;

            //     modal.classList.add('show');
            //     modal.style.display = 'block';
            //     document.body.classList.add('modal-open');
            //     // openModal(modal)

            //     modal.querySelectorAll('[data-modal-dismiss]').forEach(btn => {
            //         btn.addEventListener('click', () => closeModal(modal));
            //     });

            //     if (modal.dataset.route && modal.dataset.imageInput) {
            //         setupMediaModal(modal);
            //     }
            // });

            const offcanvases = document.querySelectorAll('.offcanvas');

            offcanvases.forEach(offcanvas => {
                offcanvas.addEventListener('show.bs.offcanvas', event => {
                    const target = event.target; // safer to use event.target in event listeners
                    if (target.dataset.route && target.dataset.imageInput) {
                        setupMediaModal(target);
                    }
                    const nestedModals = offcanvas.querySelectorAll('.modal');
                    nestedModals.forEach(modal => {
                        // Move modal to body to fix z-index/backdrop issues
                        if (!document.body.contains(modal)) {
                            document.body.appendChild(modal);
                        }
                    });
                });
            });

            function refreshUploadInput(form) {
                const fileInput = form.querySelector('input[type="file"]');
                if (fileInput) {
                    fileInput.value = "";
                }
            }

            // Handle insert/save click globally
            document.addEventListener('click', function(e) {
                const saveBtn = e.target.closest('[id^="save-media-"]');
                if (!saveBtn) return;

                const modalId = saveBtn.closest('.offcanvas')?.id || currentModalId;
                const modal = document.getElementById(modalId);
                const inputName = modal.dataset.imageInput;
                const from = modal.dataset.from;
                const imageWrapper = document.getElementById(`${modalId}-wrapper`);
                const previewContainer = modal.querySelector(`.preview`);
                const checkboxes = modal.querySelectorAll('.form-imagecheck-input:checked');

                if (previewContainer) previewContainer.innerHTML = '';
                if (from === 'builder') {
                    checkboxes.forEach(cb => {
                        const imgUrl = cb.dataset.url;
                        const imgUrlFullPath = cb.dataset.fullpath;
                        if (imgUrl) {
                            Alpine.store('mediaManager').insertImage(imgUrl, imgUrlFullPath);
                        }
                    });
                }

                if (imageWrapper) {
                    imageWrapper.innerHTML = '<div class="my-3">Image Preview:</div>';

                    checkboxes.forEach(cb => {
                        const imgUrl = cb.dataset.url;
                        const imgUrlFullPath = cb.dataset.fullpath;

                        imageWrapper.innerHTML += `
                        <div class="image-wrapper">
                            <img src="${imgUrlFullPath}" class="mr-3 mb-3">
                            <input type="hidden" name="${inputName}" value="${imgUrl}">
                            <span type="button" class="remove-image">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M18 6l-12 12"></path>
                                    <path d="M6 6l12 12"></path>
                                </svg>
                            </span>
                        </div>`;
                    });
                }
            });

            document.body.addEventListener('click', function(e) {
                if (e.target.closest('.remove-image')) {
                    e.target.closest('.image-wrapper').remove();
                }
            });


            // document.addEventListener('click', function(e) {
            //     const folderModalContextBtn = e.target.closest('#folder-context-modal-btn');
            //     if (!folderModalContextBtn) return;

            //     const folderContextModalId = `folder-context-${folderModalContextBtn.dataset.id}`;
            //     const modal = document.getElementById(folderContextModalId);
            //     if (!modal) return;

            //     const bsModal = tabler.bootstrap.Modal.getInstance(modal) || new tabler.bootstrap.Modal(
            //         modal);
            //     bsModal.show();
            // });

            function setupMediaModal(modal) {
                const modalId = modal.id;
                const route = modal.dataset.route;
                const inputName = modal.dataset.imageInput;
                const inputType = modal.dataset.type || 'single';
                const wrapper = document.getElementById(`ajax-container-${modalId}`);
                const previewContainer = modal.querySelector('.preview');
                let page = 1;

                currentModalId = modalId;
                currentUrl = route;

                if (wrapper) wrapper.innerHTML = '';
                if (previewContainer) previewContainer.innerHTML = '';

                loadMedia(route, modalId, page);

                const uploadForm = modal.querySelector('.ajaxform-file-upload');
                if (uploadForm) {
                    uploadForm.onsubmit = (e) => {
                        e.preventDefault();
                        const loader = modal.querySelector('.loader');
                        if (loader) loader.style.display = 'block';

                        const formData = new FormData(uploadForm);
                        const folderId = uploadForm?.querySelector('[name="parent_id"]')?.value ?? null;

                        axios.post(uploadForm.action, formData)
                            .then((response) => {
                                if (response.data.success === 'error') {
                                    toast('error', response.data.message ?? 'Upload failed.');
                                    return;
                                }
                                loadMedia(route, modalId, 1, folderId);
                                setTimeout(() => {
                                    const firstCheckbox = modal.querySelector(
                                        '.form-imagecheck-input');
                                    if (firstCheckbox) firstCheckbox.checked = true;
                                }, 300);
                                refreshUploadInput(uploadForm);
                            })
                            .catch((error) => {
                                console.error('Upload failed', error);
                            })
                            .finally(() => {
                                if (loader) loader.style.display = 'none';
                                refreshUploadInput(uploadForm);
                            });
                    };
                }

                modal.addEventListener('change', (e) => {
                    if (e.target.classList.contains('form-imagecheck-input') && inputType === 'single') {
                        if (e.target.checked) {
                            modal.querySelectorAll('.form-imagecheck-input').forEach(input => {
                                if (input !== e.target) input.checked = false;
                            });
                        }
                    }
                });

                const loadMoreBtn = modal.querySelector(`#load-more-${modalId}`);
                if (loadMoreBtn) {
                    loadMoreBtn.addEventListener('click', () => {
                        page++;
                        loadMedia(route, modalId, page);
                    });
                }
            }

            function loadMedia(url, modalId, page = 1, folderId = null) {
                const loader = document.querySelector(`#${modalId} .loader.custom`);
                const container = document.getElementById(`ajax-container-${modalId}`);
                const pagination = document.getElementById(`pagination-${modalId}`);
                if (loader) loader.style.display = 'block';

                const urlObj = new URL(url, window.location.origin);
                const params = urlObj.searchParams;
                params.set('page', page);
                if (folderId !== null) {
                    params.set('parent_id', folderId);
                }

                urlObj.search = params.toString();
                const parentId = urlObj.searchParams.get('parent_id') || '';

                axios.get(urlObj.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        container.innerHTML = response.data.html;
                        const meta = response.data.meta;
                        // set parent id 
                        // const urlParams = new URLSearchParams((new URL(url)).search);
                        // const folderId = urlParams.get('parent_id') || '';
                        const folderInput = document.getElementById(`media-folder-id-${modalId}`);
                        const mediafolderInput = document.getElementById(`media-folder-folder-id-${modalId}`);


                        if (folderInput) {
                            folderInput.value = parentId;
                        }
                        if (mediafolderInput) {
                            mediafolderInput.value = parentId;
                        }

                        if (pagination) {
                            pagination.innerHTML = '';
                            const ul = document.createElement('ul');
                            ul.className = 'pagination justify-content-center';
                            // prev button
                            if (meta.current_page > 1) {
                                ul.innerHTML += `
                            <li class="page-item">
                                <a class="page-link" href="#" data-page="${meta.current_page - 1}" rel="prev" aria-label="« Previous">‹</a>
                            </li>`;
                            }
                            // page numbers
                            for (let i = 1; i <= meta.last_page; i++) {
                                ul.innerHTML += `
                            <li class="page-item ${i === meta.current_page ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>`;
                            }
                            // Next button
                            if (meta.current_page < meta.last_page) {
                                ul.innerHTML += `
                            <li class="page-item">
                                <a class="page-link" href="#" data-page="${meta.current_page + 1}" rel="next" aria-label="Next »">›</a>
                            </li>`;
                            }

                            pagination.appendChild(ul);

                            // Attach events to all page links
                            pagination.querySelectorAll('a.page-link[data-page]').forEach(link => {
                                link.addEventListener('click', e => {
                                    e.preventDefault();
                                    const page = parseInt(link.getAttribute('data-page'));
                                    loadMedia(url, modalId, page, folderId);
                                });
                            });
                        }
                        if (loader) loader.style.display = 'none';
                    })
                    .catch(() => {
                        console.error("Failed to load media.");
                        if (loader) loader.style.display = 'none';
                    })
                    .finally(() => {
                        if (loader) loader.style.display = 'none';
                    });

                    console.log(loader.style.display)
            }


            document.addEventListener('click', function(e) {
                const link = e.target.closest('.folder-link');
                if (link) {
                    e.preventDefault();
                    const url = link.dataset.url;
                    const modalId = link.closest('[id^="ajax-container-"]').id.replace('ajax-container-',
                        '');
                    loadMedia(url, modalId, 1);
                }
            });

            document.addEventListener('click', function(e) {
                const button = e.target.closest('.move-folder');

                if (button) {
                    e.preventDefault();
                    const modal = button.closest('.modal');
                    const id = modal.querySelector('input[name="id"]').value;
                    const isFile = modal.querySelector('input[name="is_file"]').value;
                    const parent_id = modal.querySelector('select[name="folder_id"]').value;

                    axios.post("{{ route('admin.media.move.folder') }}", {
                            id: id,
                            parent_id: parent_id,
                            isFile: isFile === 'true'
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => {
                            reloadParentModal(button);
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            });

            document.addEventListener('click', function(e) {
                // Handle delete-folder click
                const deleteBtn = e.target.closest('.delete-folder');
                if (deleteBtn) {
                    e.preventDefault();

                    const folderId = deleteBtn.dataset.id;
                    const url = deleteBtn.dataset.url;
                    if (!folderId) return;

                    if (!confirm('Are you sure you want to delete this folder?')) return;

                    axios.delete(url, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => {
                            // Optionally refresh modal or UI
                            reloadParentModal(deleteBtn);
                        })
                        .catch(error => {
                            alert(error?.response?.data?.message || "Error deleting folder.");
                            console.error(error);
                        });
                }
            });

            function reloadParentModal(triggerEl) {
                const parentModal = triggerEl.closest('.offcanvas');
                if (!parentModal) {
                    location.reload(true);
                    return;
                }

                const parentModalId = parentModal.getAttribute('id');
                const parentModalRoute = parentModal.dataset.route;
                const folderInput = parentModal.querySelector(
                    `form.ajaxform-file-upload input#media-folder-id-${parentModalId}`);
                const folderId = folderInput?.value || null;

                loadMedia(parentModalRoute, parentModalId, 1, folderId);
            }

            // old load more function
            // function loadMedia(url, modalId, page = 1) {
            //     const loader = document.querySelector('.loader');
            //     const container = document.getElementById(`ajax-container-${modalId}`);
            //     if (loader) loader.style.display = 'block';

            //     axios.get(url)
            //         .then(response => {
            //             if (page === 1) {
            //                 container.innerHTML = response.data;
            //             } else {
            //                 container.insertAdjacentHTML('beforeend', response.data);
            //             }
            //         })
            //         .catch(() => {
            //             console.error("Failed to load media.");
            //         })
            //         .finally(() => {
            //             if (loader) loader.style.display = 'none';
            //         });
            // }
        });
    </script>
@endpush
