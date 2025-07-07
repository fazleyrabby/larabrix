@if (session('success') || session('error'))
    <script>
        Swal.fire({
            position: "top-end",
            text: "{{ session('success') ?? session('error') }}",
            icon: "{{ session('success') ? 'success' : 'error' }}",
            showConfirmButton: false,
            toast: true,
            timer: 2500
        })
    </script>
@endif


@push('scripts')
<script>
function confirmDelete(event, form) {
        event.preventDefault(); // Prevent the default form submission

        // Show the SweetAlert confirmation dialog
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirmed, submit the form
                form.submit(); // Use the form passed as an argument
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Handle cancel action if necessary
                console.log("Cancelled");
            }
        });

        return false; // Prevent default form submission until confirmation
    }

    function toast(type, message){
        Swal.fire({
            position: "top-end",
            text: `${message}`,
            icon: `${type ?? 'error'}`,
            showConfirmButton: false,
            toast: true,
            timer: 2500
        })
    }
</script>
@endpush
