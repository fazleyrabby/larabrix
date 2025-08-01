@extends('frontend.app')

@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <div class="mx-auto max-w-3xl" x-data>
                <header class="text-center">
                    <h1 class="text-xl font-bold text-gray-900 sm:text-3xl" x-html="`Cart (${Object.keys($store.cart.items).length})`"></h1>
                </header>
                <div class="mt-8">
                    <ul class="space-y-4">
                        <template x-if="Object.keys($store.cart.items).length === 0">
                            <li class="text-gray-500 text-sm">Your cart is empty.</li>
                        </template>
                        <template x-for="(item, key) in $store.cart.items" :key="key">
                            <li class="flex items-center gap-4">
                            <img :src="item.image"
                            alt="" class="size-16 rounded-sm object-cover" />
                            <div>
                                <h3 class="text-sm text-gray-900" x-text="item.title"></h3>
                            </div>
                            <div class="flex flex-1 items-center justify-end gap-2">
                                <form>
                                    <label for="Line1Qty" class="sr-only"> Quantity </label>

                                    <select
                                        @change="$store.cart.updateQuantity(key, +$event.target.value)"
                                        class="h-8 w-14 rounded-sm border-gray-200 bg-gray-50 p-0 text-center text-xs text-gray-600">
                                        <template x-for="qty in 10" :key="qty">
                                            <option :value="qty" x-text="qty" :selected="qty === item.quantity"></option>
                                        </template>
                                    </select>
                                </form>

                                <button class="text-gray-600 transition hover:text-red-600 cursor-pointer"
                                    @click="$store.cart.removeItem(key)"
                                >
                                    <span class="sr-only">Remove item</span>

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                            </li>
                        </template>
                    </ul>

                    <div class="mt-8 flex justify-end border-t border-gray-100 pt-8">
                        <div class="w-screen max-w-lg space-y-4">
                            <template x-if="Object.keys($store.cart.items).length > 0">
                            <dl class="space-y-0.5 text-sm text-gray-700">
                                <div class="flex justify-between">
                                    <dt>Subtotal</dt>
                                    <dd x-text="$store.cart.total"></dd>
                                </div>

                                {{-- <div class="flex justify-between">
                                    <dt>VAT</dt>
                                    <dd>£25</dd>
                                </div> --}}

                                {{-- <div class="flex justify-between">
                                    <dt>Discount</dt>
                                    <dd>-£20</dd>
                                </div> --}}

                                <div class="flex justify-between !text-base font-medium">
                                    <dt>Total</dt>
                                    <dd x-text="$store.cart.total"></dd>
                                </div>
                            </dl>
                            </template>

                            {{-- <div class="flex justify-end">
                                <span
                                    class="inline-flex items-center justify-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-indigo-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                    </svg>

                                    <p class="text-xs whitespace-nowrap">2 Discounts Applied</p>
                                </span>
                            </div> --}}

                            <template x-if="Object.keys($store.cart.items).length > 0">
                            <div class="flex justify-end">
                                <a href="#"
                                    class="block rounded-sm bg-gray-700 px-5 py-3 text-sm text-gray-100 transition hover:bg-gray-600">
                                    Checkout
                                </a>
                            </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
