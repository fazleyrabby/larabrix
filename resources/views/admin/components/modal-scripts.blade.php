@push('scripts')

<script>
document.addEventListener("DOMContentLoaded", () => {
    let currentModalId = null;
    let currentUrl = null;

    // Open modal
    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            const route = modal.dataset.route;
            const inputName = modal.dataset.imageInput;
            const inputType = modal.dataset.type;
            const wrapper = document.getElementById(`ajax-container-${modalId}`);
            const previewContainer = modal.querySelector('.preview');

            let page = 1;
            currentModalId = modalId;
            currentUrl = route;

            // Show modal
            modal.classList.add('show');
            modal.style.display = 'block';

            // Reset contents
            wrapper.innerHTML = '';
            previewContainer.innerHTML = '';

            // Load initial media
            loadMedia(route, modalId, page);

            // File Upload (inside modal)
            const uploadForm = modal.querySelector('.ajaxform-file-upload');
            if (uploadForm) {
                uploadForm.onsubmit = (e) => {
                    e.preventDefault();
                    const loader = modal.querySelector('.loader');
                    loader.style.display = 'block';
                    const formData = new FormData(uploadForm);

                    axios.post(uploadForm.action, formData)
                        .then(() => {
                            loadMedia(route, modalId, 1);
                            setTimeout(() => {
                                const firstCheckbox = modal.querySelector('.form-imagecheck-input');
                                if (firstCheckbox) firstCheckbox.checked = true;
                            }, 300);
                            uploadForm.reset()
                        })
                        .catch(error => {
                            console.error('Upload failed', error);
                            uploadForm.reset()
                        })
                        .finally(() => {
                            loader.style.display = 'none';
                            uploadForm.reset()
                        });
                };
            }

            // Handle checkbox selection for single type
            modal.addEventListener('change', (e) => {
                if (e.target.classList.contains('form-imagecheck-input') && inputType === 'single') {
                    if (e.target.checked) {
                        modal.querySelectorAll('.form-imagecheck-input').forEach(input => {
                            if (input !== e.target) input.checked = false;
                        });
                    }
                }
            });

            // Insert selected image(s)
            // modal.querySelector('.preview').addEventListener('click', (e) => {
            //     if (e.target.classList.contains('btn-insert')) {
            //         const checkedInputs = modal.querySelectorAll('.form-imagecheck-input:checked');
            //         previewContainer.innerHTML = '<div class="my-4">Image Preview:</div>';

            //         checkedInputs.forEach(input => {
            //             const url = input.dataset.url;
            //             previewContainer.innerHTML += `
            //                 <img src="${url}" width="100" class="me-2 mb-2">
            //                 <input type="hidden" name="${inputName}" value="${url}">
            //             `;
            //         });

            //         closeModal(modal);
            //     }
            // });

            // Load more media (if button exists)
            const loadMoreBtn = modal.querySelector(`#load-more-${modalId}`);
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', () => {
                    page++;
                    loadMedia(`${route}&page=${page}`, modalId, page);
                });
            }

            // Dismiss modal
            modal.querySelectorAll('[data-modal-dismiss]').forEach(btn => {
                btn.addEventListener('click', () => closeModal(modal));
            });
        });
    });

    // Handle insert/save click globally
    document.addEventListener('click', function (e) {
        const saveBtn = e.target.closest('[id^="save-media-"]');
        if (!saveBtn) return;

        const modalId = currentModalId;
        const modal = document.getElementById(modalId);
        const inputName = modal.dataset.imageInput;
        const imageWrapper = document.getElementById(`${modalId}-wrapper`);
        const previewContainer = modal.querySelector(`.preview`);
        const checkboxes = modal.querySelectorAll('.form-imagecheck-input:checked');

        if (previewContainer) previewContainer.innerHTML = '';
        if (imageWrapper) {
            imageWrapper.innerHTML = '<div class="my-3">Image Preview:</div>';

            checkboxes.forEach(cb => {
                const imgUrl = cb.dataset.url;
                const imgUrlFullPath = cb.dataset.fullpath;
                imageWrapper.innerHTML += `
                    <img width="200" src="${imgUrlFullPath}" class="mr-3 mb-3">
                    <input type="hidden" name="${inputName}" value="${imgUrl}">
                `;
            });
        }

        closeModal(modal);
    });

    function closeModal(modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';

        // If you're using a backdrop class manually (e.g., added in HTML or via JS)
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }

        // Optional: restore scroll if it was disabled
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
    }

    function loadMedia(url, modalId, page = 1) {
        const loader = document.querySelector('.loader');
        const container = document.getElementById(`ajax-container-${modalId}`);
        if (loader) loader.style.display = 'block';

        axios.get(url)
            .then(response => {
                if (page === 1) {
                    container.innerHTML = response.data;
                } else {
                    container.insertAdjacentHTML('beforeend', response.data);
                }
            })
            .catch(() => {
                console.error("Failed to load media.");
            })
            .finally(() => {
                if (loader) loader.style.display = 'none';
            });
    }
});
</script>

@endpush
