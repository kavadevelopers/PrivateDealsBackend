<link rel="stylesheet" href="{{ asset('website-assets/libs/sweetalert/sweetalert.min.css') }}">
<script defer src="{{ asset('website-assets/libs/sweetalert/sweetalert.min.js') }}"></script>
<script>
    // Success SweetAlert
    function successAlert(message) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "success",
            title: message
        });
    }

    // Info SweetAlert
    function infoAlert(message) {
        Swal.fire({
            title: "Info",
            text: message,
            icon: "info",
            confirmButtonText: "OK"
        });
    }

    // Warning SweetAlert
    function warningAlert(message) {
        Swal.fire({
            title: "Warning!",
            text: message,
            icon: "warning",
            confirmButtonText: "OK"
        });
    }

    // Error SweetAlert
    function errorAlert(title_text) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: title_text
        });
    }

    // Example of using the SweetAlert functions
    $(document).ready(function() {
        @if (Session::has('success'))
            successAlert("{{ Session::get('success') }}");
        @endif
        @if (Session::has('info'))
            infoAlert("{{ Session::get('info') }}");
        @endif
        @if (Session::has('warning'))
            warningAlert("{{ Session::get('warning') }}");
        @endif
        @if (Session::has('error'))
            errorAlert("{{ Session::get('error') }}");
        @endif
    });
</script>
