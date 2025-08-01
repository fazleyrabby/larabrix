<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $page->title ?? 'Page' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/frontend/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Outfit", system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        .page-container{
            min-height: calc(100dvh - 280px);
        }
    </style>

    @stack('styles')
</head>

<body class="light">
    @include('frontend.partials.header')
    <main>
        @yield('content')
    </main>


    {{-- common toast popup  --}}
    <div x-init="console.log($store.toast)" x-cloak x-show="$store.toast.visible" x-transition
        @click="$store.toast.visible = false" class="toast fixed bottom-4 right-4 z-50 cursor-pointer">
        <div :class="`alert ${$store.toast.type === 'success' ? 'alert-success' : 'alert-error'} text-white`">
            <span x-text="$store.toast.message"></span>
        </div>
    </div>

    @include('frontend.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.11.0/axios.min.js"
        integrity="sha512-h9644v03pHqrIHThkvXhB2PJ8zf5E9IyVnrSfZg8Yj8k4RsO4zldcQc4Bi9iVLUCCsqNY0b4WXVV4UB+wbWENA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @include('frontend.scripts.alpine')
    @stack('scripts')    
</body>

</html>
