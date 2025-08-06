<header class="bg-white dark:bg-gray-900">
    <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex-1 md:flex md:items-center md:gap-12">
                <a class="block text-teal-600 dark:text-teal-300"
                    href="{{ route('frontend.pages.show', ['slug' => $pageSlug ?? 'test']) }}">
                    <span class="sr-only">Home</span>
                    <svg class="h-8" viewBox="0 0 28 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0.41 10.3847C1.14777 7.4194 2.85643 4.7861 5.2639 2.90424C7.6714 1.02234 10.6393 0 13.695 0C16.7507 0 19.7186 1.02234 22.1261 2.90424C24.5336 4.7861 26.2422 7.4194 26.98 10.3847H25.78C23.7557 10.3549 21.7729 10.9599 20.11 12.1147C20.014 12.1842 19.9138 12.2477 19.81 12.3047H19.67C19.5662 12.2477 19.466 12.1842 19.37 12.1147C17.6924 10.9866 15.7166 10.3841 13.695 10.3841C11.6734 10.3841 9.6976 10.9866 8.02 12.1147C7.924 12.1842 7.8238 12.2477 7.72 12.3047H7.58C7.4762 12.2477 7.376 12.1842 7.28 12.1147C5.6171 10.9599 3.6343 10.3549 1.61 10.3847H0.41ZM23.62 16.6547C24.236 16.175 24.9995 15.924 25.78 15.9447H27.39V12.7347H25.78C24.4052 12.7181 23.0619 13.146 21.95 13.9547C21.3243 14.416 20.5674 14.6649 19.79 14.6649C19.0126 14.6649 18.2557 14.416 17.63 13.9547C16.4899 13.1611 15.1341 12.7356 13.745 12.7356C12.3559 12.7356 11.0001 13.1611 9.86 13.9547C9.2343 14.416 8.4774 14.6649 7.7 14.6649C6.9226 14.6649 6.1657 14.416 5.54 13.9547C4.4144 13.1356 3.0518 12.7072 1.66 12.7347H0V15.9447H1.61C2.39051 15.924 3.154 16.175 3.77 16.6547C4.908 17.4489 6.2623 17.8747 7.65 17.8747C9.0377 17.8747 10.392 17.4489 11.53 16.6547C12.1468 16.1765 12.9097 15.9257 13.69 15.9447C14.4708 15.9223 15.2348 16.1735 15.85 16.6547C16.9901 17.4484 18.3459 17.8738 19.735 17.8738C21.1241 17.8738 22.4799 17.4484 23.62 16.6547ZM23.62 22.3947C24.236 21.915 24.9995 21.664 25.78 21.6847H27.39V18.4747H25.78C24.4052 18.4581 23.0619 18.886 21.95 19.6947C21.3243 20.156 20.5674 20.4049 19.79 20.4049C19.0126 20.4049 18.2557 20.156 17.63 19.6947C16.4899 18.9011 15.1341 18.4757 13.745 18.4757C12.3559 18.4757 11.0001 18.9011 9.86 19.6947C9.2343 20.156 8.4774 20.4049 7.7 20.4049C6.9226 20.4049 6.1657 20.156 5.54 19.6947C4.4144 18.8757 3.0518 18.4472 1.66 18.4747H0V21.6847H1.61C2.39051 21.664 3.154 21.915 3.77 22.3947C4.908 23.1889 6.2623 23.6147 7.65 23.6147C9.0377 23.6147 10.392 23.1889 11.53 22.3947C12.1468 21.9165 12.9097 21.6657 13.69 21.6847C14.4708 21.6623 15.2348 21.9135 15.85 22.3947C16.9901 23.1884 18.3459 23.6138 19.735 23.6138C21.1241 23.6138 22.4799 23.1884 23.62 22.3947Z"
                            fill="currentColor" />
                    </svg>
                </a>
            </div>

            <div x-data="{ isMenuOpen: false, isCartOpen: false }" class="md:flex md:items-center md:gap-12">
                <nav aria-label="Global" class="md:block hidden w-full md:w-auto mt-4 md:mt-0">
                    @php
                        $menu = \App\Models\Menu::with('childrenRecursive')->where('type', 'header')->get();
                    @endphp

                    <ul class="flex items-center gap-4 text-sm">
                        @include('frontend.partials.menu-item', ['items' => $menu])

                        @auth
                            <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('user.login') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                                Log in
                            </a>
                        @endauth

                        <div x-data="{ isCartOpen: false }" x-transition x-cloak class="relative">
                            <!-- 🛍️ Cart Button -->
                            <button type="button" @click="isCartOpen = true"
                                class="relative text-gray-500 transition hover:text-gray-500/75 dark:text-white dark:hover:text-white/75 cursor-pointer">

                                <!-- Cart Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-4">
                                    <path fill-rule="evenodd"
                                        d="M6 5v1H4.667a1.75 1.75 0 0 0-1.743 1.598l-.826 9.5A1.75 1.75 0 0 0 3.84 19H16.16a1.75 1.75 0 0 0 1.743-1.902l-.826-9.5A1.75 1.75 0 0 0 15.333 6H14V5a4 4 0 0 0-8 0Zm4-2.5A2.5 2.5 0 0 0 7.5 5v1h5V5A2.5 2.5 0 0 0 10 2.5ZM7.5 10a2.5 2.5 0 0 0 5 0V8.75a.75.75 0 0 1 1.5 0V10a4 4 0 0 1-8 0V8.75a.75.75 0 0 1 1.5 0V10Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <!-- Counter badge -->
                                <span x-show="Object.keys($store.cart.items).length > 0"
                                    x-text="Object.keys($store.cart.items).length"
                                    class="absolute -top-2 -right-2 inline-flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[10px] text-white"></span>
                            </button>

                            <!-- 🛒 Cart Drawer -->
                            <div 
                                x-show="isCartOpen"
                                x-transition:enter="transform transition ease-in-out duration-300"
                                x-transition:enter-start="translate-x-full"
                                x-transition:enter-end="translate-x-0"
                                x-transition:leave="transform transition ease-in-out duration-300"
                                x-transition:leave-start="translate-x-0"
                                x-transition:leave-end="translate-x-full"
                                class="fixed right-0 top-0 z-50 h-full w-full max-w-sm overflow-y-auto border border-gray-600 bg-gray-100 px-4 py-8 shadow-lg sm:px-6 lg:px-8"
                                aria-modal="true"
                                role="dialog"
                                tabindex="-1"
                                @click.outside="isCartOpen = false"
                            >

                                <!-- ❌ Close Button -->
                                <button @click="isCartOpen = false"
                                    class="absolute end-4 top-4 text-gray-600 transition hover:scale-110 cursor-pointer">
                                    <span class="sr-only">Close cart</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <!-- 👉 Your cart content here -->
                                @include('frontend.carts.sidebar')

                            </div>
                        </div>
                    </ul>
                </nav>

                <div class="flex items-center gap-4">
                    <div class="block md:hidden">
                        <button @click="isMenuOpen = !isMenuOpen"
                            class="rounded-sm bg-gray-100 p-2 text-gray-600 transition hover:text-gray-600/75 dark:bg-gray-800 dark:text-white dark:hover:text-white/75">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div role="menu" :class="{ 'block': isMenuOpen, 'hidden': !isMenuOpen }"
                    class="absolute end-0 top-15 z-1 w-full overflow-hidden rounded border border-gray-300 bg-white shadow-sm">

                    @auth
                        <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                            class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                            role="menuitem">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('user.login') }}"
                            class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                            role="menuitem">
                            Login
                        </a>
                    @endauth

                    <a href="{{ route('frontend.products.index') }}"
                        class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                        role="menuitem">
                        Products
                    </a>

                    <div x-data="{ isCartOpen: false }" x-transition x-cloak class="relative w-full">
                        <!-- 🛍️ Cart Button -->
                        <button type="button" @click="isCartOpen = true"
                           class="cursor-pointer text-left w-full block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900">

                            Cart
                        </button>

                        <!-- 🛒 Cart Drawer -->
                        <div x-show="isCartOpen" x-transition
                            class="fixed right-0 top-0 z-50 h-full w-full max-w-sm overflow-y-auto border border-gray-600 bg-gray-100 px-4 py-8 shadow-lg sm:px-6 lg:px-8"
                            aria-modal="true" role="dialog" tabindex="-1" @click.outside="isCartOpen = false">

                            <!-- ❌ Close Button -->
                            <button @click="isCartOpen = false"
                                class="absolute end-4 top-4 text-gray-600 transition hover:scale-110 cursor-pointer">
                                <span class="sr-only">Close cart</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- 👉 Your cart content here -->
                            @include('frontend.carts.sidebar')

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
