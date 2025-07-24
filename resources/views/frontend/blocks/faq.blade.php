<div class="mx-auto w-full max-w-screen-md px-4 lg:min-h-[400px] lg:grid lg:place-content-center py-3" id="{{ $index }}">
    <div class="space-y-4">
        @foreach ($data['items'] as $item)
            <details class="group [&_summary::-webkit-details-marker]:hidden" open>
                <summary
                    class="flex items-center justify-between gap-1.5 rounded-md border border-gray-100 bg-gray-50 p-4 text-gray-900">
                    <h2 class="text-lg font-medium">{{ $item['question'] }}</h2>

                    <svg class="size-5 shrink-0 transition-transform duration-300 group-open:-rotate-180"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </summary>

                <p class="px-4 pt-4 text-gray-900">
                    {{ $item['answer'] }}
                </p>
            </details>
        @endforeach
    </div>
</div>
