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

    @stack('scripts')
</body>
</html>