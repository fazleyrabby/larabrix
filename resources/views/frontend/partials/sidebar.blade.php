<div x-data="{ sidebarOpen: true }" class="mt-4 lg:mt-8 lg:grid lg:grid-cols-4 lg:items-stretch lg:gap-8 relative">
    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="col-span-1 fixed lg:static top-0 left-0 h-full w-64 lg:w-auto bg-gray-100 transition-transform duration-300 z-20">
        <div class="space-y-4 lg:block h-full">
            <div class="flex h-full flex-col justify-between bg-white">
                <div class="">
                    {{-- <span class="grid h-10 w-32 place-content-center rounded-lg bg-gray-100 text-xs text-gray-600">
                                Logo
                            </span> --}}

                    <ul class="mt-6 space-y-1">
                        <li>
                            <a href="{{ route('user.dashboard') }}"
                                class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-700 {{ request()->is('user/dashboard') ? 'bg-gray-100' : '' }}">
                                Orders
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.transactions') }}"
                                class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-700 {{ request()->is('user/transactions') ? 'bg-gray-100' : '' }}">
                                Transactions
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-700">
                                Settings
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('user.logout') }}"
                                class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-700">
                                Logout
                            </a>
                        </li>


                        {{-- <li>
                                    <details class="group [&_summary::-webkit-details-marker]:hidden">
                                        <summary
                                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                            <span class="text-sm font-medium"> Teams </span>

                                            <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </summary>

                                        <ul class="mt-2 space-y-1 px-4">
                                            <li>
                                                <a href="#"
                                                    class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                                    Banned Users
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#"
                                                    class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                                    Calendar
                                                </a>
                                            </li>
                                        </ul>
                                    </details>
                                </li> --}}

                        {{-- <li>
                                    <a href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                        Billing
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                        Invoices
                                    </a>
                                </li>

                                <li>
                                    <details class="group [&_summary::-webkit-details-marker]:hidden">
                                        <summary
                                            class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                            <span class="text-sm font-medium"> Account </span>

                                            <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </summary>

                                        <ul class="mt-2 space-y-1 px-4">
                                            <li>
                                                <a href="#"
                                                    class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                                    Details
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#"
                                                    class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                                    Security
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#"
                                                    class="w-full rounded-lg px-4 py-2 [text-align:_inherit] text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                                    Logout
                                                </a>
                                            </li>
                                        </ul>
                                    </details>
                                </li> --}}
                    </ul>
                </div>

                <div class="sticky inset-x-0 bottom-0 border-t border-gray-100">
                    <a href="#" class="flex items-center gap-2 bg-white p-4 hover:bg-gray-50">
                        <img alt=""
                            src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80"
                            class="size-10 rounded-full object-cover" />

                        <div>
                            <p class="text-xs">
                                <strong class="block font-medium">{{ auth()->user()->name }}</strong>

                                <span> {{ auth()->user()->email }} </span>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Toggle Button -->
    <div class="fixed top-4 left-0 z-30 lg:hidden" :class="sidebarOpen ? 'left-[260px]' : 'left-4'"
        x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="left-4"
        x-transition:enter-end="left-[260px]" x-transition:leave="transition ease-in-out duration-300"
        x-transition:leave-start="left-[260px]" x-transition:leave-end="left-4">
        <button @click="sidebarOpen = !sidebarOpen" class="p-1 bg-gray-200 rounded-md text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </div>

    <!-- Main Content -->
    <div :class="sidebarOpen ? 'col-span-3' : 'col-span-4'" class="transition-all duration-300 lg:ml-0">
        {{ $slot }}
    </div>
</div>
