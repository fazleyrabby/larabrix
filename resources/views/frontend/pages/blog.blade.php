@extends('frontend.app')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        hljs.highlightAll();
    </script>
@endpush


@section('content')
    <section class="min-h-screen bg-white py-12">
        <div class="max-w-3xl mx-auto px-4">

            <!-- Blog Title -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                {{ $blog->title ?? 'Blog Post Title' }}
            </h1>

            <!-- Blog Metadata -->
            <div class="text-sm text-gray-500 mb-6">
                <span>By {{ $blog->author ?? 'Author Name' }}</span>
                <span class="mx-2">·</span>
                <span>{{ \Carbon\Carbon::parse($blog->created_at)->format('F j, Y') ?? 'Date' }}</span>
            </div>

            <!-- Featured Image -->
            @if (!empty($blog->image))
                <img src="{{ $blog->image }}" alt="Featured Image"
                    class="w-full rounded-lg mb-8 object-cover max-h-[400px]" />
            @endif

            <!-- Blog Content -->
            <article class="prose prose-lg max-w-none text-gray-800">
                {!! $blog->body !!}
            </article>

            <!-- Optional Tags or Categories -->
            @if (!empty($blog->tags))
                <div class="mt-8 flex flex-wrap gap-2">
                    @foreach ($blog->tags as $tag)
                        <span class="text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                            #{{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif

        </div>
    </section>
@endsection
