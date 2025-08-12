@foreach ($items as $item)
    <li class="relative group">
        <a href="{{ $item->href ? url($item->href) : '#' }}"
           class="text-gray-500 transition hover:text-gray-500/75 dark:text-white dark:hover:text-white/75">
            {{ $item->title }}
        </a>

        @if ($item->childrenRecursive->isNotEmpty())
            <ul class="absolute left-0 mt-2 hidden group-hover:block bg-white shadow-lg rounded-md px-4 py-2 z-50 dark:bg-gray-800">
                @include('frontend.partials.menu-item', ['items' => $item->childrenRecursive])
            </ul>
        @endif
    </li>
@endforeach