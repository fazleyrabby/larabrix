@extends('frontend.app')

@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <header>
                <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Product Collection</h2>

                <p class="mt-4 max-w-md text-gray-500">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque praesentium cumque iure
                    dicta incidunt est ipsam, officia dolor fugit natus?
                </p>
            </header>

            <div class="mt-8 block lg:hidden">
                <button
                    class="flex cursor-pointer items-center gap-2 border-b border-gray-400 pb-1 text-gray-900 transition hover:border-gray-600">
                    <span class="text-sm font-medium"> Filters & Sorting </span>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 rtl:rotate-180">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>

            <div class="mt-4 lg:mt-8 lg:grid lg:grid-cols-4 lg:items-start lg:gap-8">
                <div class="hidden space-y-4 lg:block">
                    <div>
                        <label for="SortBy" class="block text-xs font-medium text-gray-700"> Sort By </label>

                        <select class="select">
                            <option>Sort By</option>
                            <option value="Title, DESC">Title, DESC</option>
                            <option value="Title, ASC">Title, ASC</option>
                            <option value="Price, DESC">Price, DESC</option>
                            <option value="Price, ASC">Price, ASC</option>
                        </select>
                    </div>

                    <div>
                        <p class="block text-xs font-medium text-gray-700">Filters</p>

                        <div class="mt-1 space-y-2">
                            <details
                                class="overflow-hidden rounded-sm border border-gray-300 [&_summary::-webkit-details-marker]:hidden">
                                <summary
                                    class="flex cursor-pointer items-center justify-between gap-2 p-4 text-gray-900 transition">
                                    <span class="text-sm font-medium"> Availability </span>

                                    <span class="transition group-open:-rotate-180">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </span>
                                </summary>

                                <div class="border-t border-gray-200 bg-white">
                                    <header class="flex items-center justify-between p-4">
                                        <span class="text-sm text-gray-700"> 0 Selected </span>

                                        <button type="button" class="text-sm text-gray-900 underline underline-offset-4">
                                            Reset
                                        </button>
                                    </header>

                                    <ul class="space-y-1 border-t border-gray-200 p-4">
                                        <li>
                                            <label for="FilterInStock" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterInStock"
                                                    class="size-5 rounded-sm border-gray-300 shadow-sm" />

                                                <span class="text-sm font-medium text-gray-700"> In Stock (5+) </span>
                                            </label>
                                        </li>

                                        <li>
                                            <label for="FilterPreOrder" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterPreOrder"
                                                    class="size-5 rounded-sm border-gray-300 shadow-sm" />

                                                <span class="text-sm font-medium text-gray-700"> Pre Order (3+) </span>
                                            </label>
                                        </li>

                                        <li>
                                            <label for="FilterOutOfStock" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterOutOfStock"
                                                    class="size-5 rounded-sm border-gray-300 shadow-sm" />

                                                <span class="text-sm font-medium text-gray-700"> Out of Stock (10+) </span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </details>

                            <details
                                class="overflow-hidden rounded-sm border border-gray-300 [&_summary::-webkit-details-marker]:hidden">
                                <summary
                                    class="flex cursor-pointer items-center justify-between gap-2 p-4 text-gray-900 transition">
                                    <span class="text-sm font-medium"> Price </span>

                                    <span class="transition group-open:-rotate-180">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </span>
                                </summary>

                                <div class="border-t border-gray-200 bg-white">
                                    <header class="flex items-center justify-between p-4">
                                        <span class="text-sm text-gray-700"> The highest price is $600 </span>

                                        <button type="button" class="text-sm text-gray-900 underline underline-offset-4">
                                            Reset
                                        </button>
                                    </header>

                                    <div class="border-t border-gray-200 p-4">
                                        <div class="flex justify-between gap-4">
                                            <label for="FilterPriceFrom" class="flex items-center gap-2">
                                                <span class="text-sm text-gray-600">$</span>

                                                <input type="text" placeholder="Type here" class="input" />
                                            </label>

                                            <label for="FilterPriceTo" class="flex items-center gap-2">
                                                <span class="text-sm text-gray-600">$</span>

                                                <input type="text" placeholder="Type here" class="input" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </details>

                            <details
                                class="overflow-hidden rounded-sm border border-gray-300 [&_summary::-webkit-details-marker]:hidden">
                                <summary
                                    class="flex cursor-pointer items-center justify-between gap-2 p-4 text-gray-900 transition">
                                    <span class="text-sm font-medium"> Colors </span>

                                    <span class="transition group-open:-rotate-180">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </span>
                                </summary>

                                <div class="border-t border-gray-200 bg-white">
                                    <header class="flex items-center justify-between p-4">
                                        <span class="text-sm text-gray-700"> 0 Selected </span>

                                        <button type="button" class="text-sm text-gray-900 underline underline-offset-4">
                                            Reset
                                        </button>
                                    </header>

                                    <ul class="space-y-1 border-t border-gray-200 p-4">
                                        <li>
                                            <label for="FilterRed" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterRed"
                                                    class="size-5 rounded-sm border-gray-300 shadow-sm" />

                                                <span class="text-sm font-medium text-gray-700"> Red </span>
                                            </label>
                                        </li>

                                        <li>
                                            <label for="FilterBlue" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterBlue"
                                                    class="size-5 rounded-sm border-gray-300 shadow-sm" />

                                                <span class="text-sm font-medium text-gray-700"> Blue </span>
                                            </label>
                                        </li>

                                        <li>
                                            <label for="FilterGreen" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterGreen"
                                                    class="size-5 rounded-sm border-gray-300 shadow-sm" />

                                                <span class="text-sm font-medium text-gray-700"> Green </span>
                                            </label>
                                        </li>

                                        <li>
                                            <label for="FilterOrange" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterOrange"
                                                    class="size-5 rounded-sm border-gray-300 shadow-sm" />

                                                <span class="text-sm font-medium text-gray-700"> Orange </span>
                                            </label>
                                        </li>

                                        <li>
                                            <label for="FilterPurple" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterPurple"
                                                    class="size-5 rounded-sm border-gray-300 shadow-sm" />

                                                <span class="text-sm font-medium text-gray-700"> Purple </span>
                                            </label>
                                        </li>

                                        <li>
                                            <label for="FilterTeal" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterTeal"
                                                    class="size-5 rounded-sm border-gray-300 shadow-sm" />

                                                <span class="text-sm font-medium text-gray-700"> Teal </span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </details>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <ul class="grid gap-4 sm:grid-cols-3 lg:grid-cols-3 mb-4">
                        @foreach ($products as $product)
                            <li>
                                <div class="group relative block overflow-hidden border border-gray-100 bg-white">
                                    <button type="button"
                                        class="absolute end-4 top-4 z-10 rounded-full bg-white p-1.5 text-gray-900 transition hover:text-gray-900/75">
                                        <span class="sr-only">Wishlist</span>

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                        </svg>
                                    </button>

                                    <a href="{{ route('frontend.products.show', $product->slug) }}">
                                        <img src="{{ $product->image ? asset($product->image) : 'https://placehold.co/400' }}"
                                            alt=""
                                            class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72" />
                                    </a>

                                <div class="p-6">
                                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                                            <a href="{{ route('frontend.products.show', $product->slug) }}">{{ $product->title }}</a>
                                        </h3>

                                        <p class="mt-1.5 text-sm text-gray-700">${{ $product->price }}</p>

                                        <div x-data="cart({{ $product->id }})">
                                            <button type="button" @click="addToCart()"
                                                class="btn mt-4 block w-full btn-neutral">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    {{ $products->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </section>
@endsection
