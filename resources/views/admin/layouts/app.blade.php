<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('admin/dist/libs/tom-select/dist/css/tom-select.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler-flags.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler-payments.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler-vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler-themes.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/preview/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/style.css') }}">

    <style>
        /* @import url('https://rsms.me/inter/inter.css'); */
        /* :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        } */
        :root {
            --tblr-font-sans-serif: 'system ui', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
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
<body class="@yield('container-class')">
    <!-- Sidebar -->
    @if (empty($hideSidebar))
        @include('admin.partials.sidebar')
    @endif

    <!-- Main content -->
    <div class="page">
        <!-- Navbar -->
        @if (empty($hideNavbar))
            @include('admin.partials.navbar')
        @endif

        <!-- Page content -->
        <div class="page-wrapper">
            @yield('content')
        </div>

        @if (trim($__env->yieldContent('title')) !== 'Kanban Board' && empty($hideFooter))
            @include('admin.partials.footer')
        @endif

    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.11.0/axios.min.js"
        integrity="sha512-h9644v03pHqrIHThkvXhB2PJ8zf5E9IyVnrSfZg8Yj8k4RsO4zldcQc4Bi9iVLUCCsqNY0b4WXVV4UB+wbWENA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @include('admin.components.alerts')
    @include('admin.components.scripts')
    @include('admin.components.modal-scripts')
    @stack('scripts')

</body>
</html>
