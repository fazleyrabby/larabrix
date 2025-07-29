<div class="bg-white min-h-[300px] px-6 py-10" id="{{ $index }}">
    <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">{{ $data['heading']['value'] }}</h2>
    <div class="flex flex-wrap justify-center items-start gap-6">
        @foreach ($data['posts'] ?? [] as $post)
            <article class="w-full max-w-sm overflow-hidden rounded-lg shadow-sm transition hover:shadow-lg">
                <img alt=""
                    src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?ixlib=rb-1.2.1&ixid=MnwxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80"
                    class="h-56 w-full object-cover" />

                <div class="bg-white p-4 sm:p-6">
                    <time datetime="2022-10-10" class="block text-xs text-gray-500"> {{ $post['published_at'] }} </time>

                    <a href="{{ $post['url'] }}">
                        <h3 class="mt-0.5 text-lg text-gray-900">{{ $post['title'] }}</h3>
                    </a>

                    <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-500">
                        {{ $post['excerpt'] }}
                    </p>
                </div>
            </article>
        @endforeach
    </div>
</div>
