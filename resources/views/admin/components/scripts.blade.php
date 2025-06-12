@push('scripts')
<script>
    function updateData(element){
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
    if(bulkDeleteBtn){
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
</script>
@endpush