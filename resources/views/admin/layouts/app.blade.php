<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('admin/dist/libs/tom-select/dist/css/tom-select.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler-flags.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler-payments.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler-vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler-themes.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/preview/css/demo.css') }}">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
        .table-responsive{
            min-height: 200px;
        }
        .swal2-success-circular-line-left,.swal2-success-fix,.swal2-success-circular-line-right{
            background-color: transparent !important;
        }
      </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main content -->
    <div class="page">
        <!-- Navbar -->
        @include('admin.partials.navbar')

        <!-- Page content -->
        <div class="page-wrapper">
            @yield('content')
        </div>

        @include('admin.partials.footer')
    </div>

    <script src="{{ asset('admin/dist/js/tabler-theme.min.js') }}"></script>
    <!-- Libs JS -->
    <script src="{{ asset('admin/dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/jsvectormap/dist/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/jsvectormap/dist/maps/world.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/jsvectormap/dist/maps/world-merc.js') }}"></script>
    {{-- <script src="{{ asset('admin/dist/libs/sweetalert.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/dist/libs/tom-select/dist/js/tom-select.base.min.js') }}"></script>

    <!-- Tabler Core -->
    <script src="{{ asset('admin/dist/js/tabler.min.js') }}"></script>
    <script src="{{ asset('admin/preview/js/demo.min.js') }}"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    @include('admin.components.alerts')
    @include('admin.components.scripts')
    @stack('scripts')
</body>
</html>
