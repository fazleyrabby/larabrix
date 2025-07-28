<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $page->title ?? 'Page' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/frontend/app.css')
</head>

<body>
    @include('frontend.partials.header') {{-- optional --}}
    <main>
        @yield('content')
    </main>
    @include('frontend.partials.footer') {{-- optional --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.11.0/axios.min.js"
        integrity="sha512-h9644v03pHqrIHThkvXhB2PJ8zf5E9IyVnrSfZg8Yj8k4RsO4zldcQc4Bi9iVLUCCsqNY0b4WXVV4UB+wbWENA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>

</html>
