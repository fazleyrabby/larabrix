<section class="py-10 min-h-[400px]" id="{{ $index }}">
  <div class="max-w-6xl mx-auto px-4">
    @if (!empty($data['heading']))
      <h2 class="text-3xl font-semibold text-center mb-10">{{ $data['heading']['value'] ?? '' }}</h2>
    @endif

    <div class="flex flex-wrap justify-center gap-8 text-center">
      @foreach ($data['items']['value'] ?? [] as $item)
        <div class="w-full max-w-sm flex flex-col items-center text-center">
          <div>
            <h3 class="text-xl font-semibold text-gray-800">{{ $item['title'] ?? 'Featured title' }}</h3>
            <p class="mt-2 text-gray-600">{{ $item['description'] ?? 'No description available.' }}</p>
            {{-- <a href="#" class="inline-block mt-4 px-5 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded">
              Primary button
            </a> --}}
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>