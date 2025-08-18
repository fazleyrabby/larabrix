@push('scripts')
    <script>
        function updateData(element) {
            const limit = element.value;
            const route = element.dataset.route;
            const searchInput = document.querySelector('input[name="q"]').value;
            const newUrl = `${route}?limit=${limit}&q=${encodeURIComponent(searchInput)}`;
            const limitInput = document.getElementById('limitInput');
            limitInput.value = limit;
            window.location.href = newUrl;
        }
    </script>

    <script>
        const selectAllCheckbox = document.getElementById('select-all-items');
        const productCheckboxes = document.querySelectorAll('.selected-item');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                productCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                toggleBulkDeleteButton();
            });
        }
        productCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', toggleBulkDeleteButton);
        });

        function toggleBulkDeleteButton() {
            const anyChecked = Array.from(productCheckboxes).some(checkbox => checkbox.checked);
            bulkDeleteBtn.disabled = !anyChecked;
        }

        // Bulk delete functionality
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function() {
                const selectedProductIds = Array.from(productCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedProductIds.length > 0) {
                    // Use SweetAlert for confirmation dialog
                    const totalItems = selectedProductIds.length;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to delete (${totalItems}) selected items. This action cannot be undone!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete them!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Call function to submit the form with the selected product IDs
                            submitBulkDeleteForm(selectedProductIds, this.dataset.route);
                        }
                    });
                }
            });
        }


        function submitBulkDeleteForm(productIds, actionUrl) {
            // Create a form element
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = actionUrl; // Use the route from the button's data-route

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}'; // CSRF token from Laravel
            form.appendChild(csrfInput);

            // Add the method spoofing input for DELETE request
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE'; // Spoof the method to DELETE
            form.appendChild(methodInput);

            // Add the selected product IDs as hidden inputs
            productIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]'; // Name the inputs as an array
                input.value = id;
                form.appendChild(input);
            });

            // Append the form to the body and submit it
            document.body.appendChild(form);
            form.submit();
        }

        function swal(title, text, type) {
            Swal.fire({
                title: 'Are you sure?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel'
            })
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.addEventListener("submit", async function(e) {
                const form = e.target;

                if (form.classList.contains("ajax-form")) {
                    e.preventDefault();

                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalBtnHTML = submitBtn.innerHTML;

                    // CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                        'content');

                    // Prepare FormData
                    const formData = new FormData(form);

                    try {
                        // Disable button and show loading
                        submitBtn.innerHTML = "Please Wait....";
                        submitBtn.disabled = true;

                        const response = await axios.post(form.action, formData, {
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'multipart/form-data',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        // Re-enable button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHTML;

                        // Show toast
                        toast(response.data.success ?? 'error', response.data.message ?? response.data);

                        // Optional: run success callback
                        if (typeof success === "function") {
                            const refreshUrl = form.dataset.refreshUrl ?? "";
                            const refreshTarget = form.dataset.refreshTarget ?? "";
                            success(response.data.message ?? response.data, refreshUrl, refreshTarget, form);
                        }

                    } catch (error) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHTML;

                        // Show error toasts
                        document.querySelector(".errorarea")?.classList.add("show");

                        if (error.response && error.response.data && error.response.data.errors) {
                            for (let key in error.response.data.errors) {
                                toast("error", error.response.data.errors[key]);
                            }
                        } else {
                            $message = error.response?.data?.message ?? "Something went wrong.";
                            toast("error", $message);
                        }

                        // Optional: global error handler
                        // errosresponse(error.response, error.message);
                    }

                }
            });
        });

        function loadData(url, containerSelector, target = null) {
            // const table = document.getElementById("ajax-table");
            // const container = document.getElementById("ajax-container");
            const container = typeof containerSelector === 'string' ?
                document.querySelector(containerSelector) :
                containerSelector;

            if (!container) {
                console.warn("Container not found:", containerSelector);
                return;
            }
            target?.classList.add("onLoading");
            axios.get(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    container.innerHTML = response.data.html ?? response.data;
                })
                .catch(error => {
                    console.error("Failed to load data!", error);
                })
                .finally(() => {
                    target?.classList.remove("onLoading");
                });
            target?.classList.remove("onLoading");
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function showModal(modalId) {
                const modal = document.getElementById(modalId);
                if (!modal) return;

                modal.classList.add('show');
                modal.style.display = 'block';
                document.body.classList.add('modal-open');

                // Add backdrop
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop';
                backdrop.style.cssText = `
            position: fixed;
            top: 0; left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        `;
                backdrop.dataset.modalBackdrop = modalId;
                document.body.appendChild(backdrop);
            }

            function hideModal(modalId) {
                const modal = document.getElementById(modalId);
                if (!modal) return;

                modal.classList.remove('show');
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');

                const backdrop = document.querySelector(`[data-modal-backdrop="${modalId}"]`);
                if (backdrop) backdrop.remove();
            }

            // Open modal
            document.querySelectorAll('[data-modal-toggle]').forEach(button => {
                button.addEventListener('click', e => {
                    e.preventDefault();
                    const modalId = button.getAttribute('data-modal-toggle');
                    showModal(modalId);
                });
            });

            // Close modal
            document.addEventListener('click', e => {
                if (e.target.matches('[data-modal-dismiss="modal"]')) {
                    const modal = e.target.closest('.modal');
                    if (modal && modal.id) hideModal(modal.id);
                }
            });

            // Backdrop click
            document.addEventListener('click', e => {
                const backdrop = e.target;
                if (backdrop.classList.contains('modal-backdrop')) {
                    const modalId = backdrop.dataset.modalBackdrop;
                    hideModal(modalId);
                }
            });

            // ESC key
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal.show').forEach(modal => {
                        hideModal(modal.id);
                    });
                }
            });
        });
    </script>
@endpush
