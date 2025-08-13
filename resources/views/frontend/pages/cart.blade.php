@extends('frontend.app')
@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <div class="mx-auto max-w-3xl" x-data>
                <header class="text-center">
                    <h1 class="text-xl font-bold text-gray-900 sm:text-3xl"
                        x-html="`Cart (${Object.keys($store.cart.items).length})`"></h1>
                </header>
                <div class="mt-8">
                    <div class="mt-8">
                        <div class="overflow-x-auto">
                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-if="Object.keys($store.cart.items).length === 0">
                                        <tr>
                                            <td colspan="5" class="text-center text-gray-500 text-sm">Your cart is empty.
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-for="(item, key) in $store.cart.items" :key="key">
                                        <tr>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div class="avatar">
                                                        <div class="mask mask-squircle w-12 h-12">
                                                            <img :src="item.image" alt="" />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold" x-text="item.title"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span x-text="`$${parseFloat(item.price).toFixed(2)}`"></span>
                                            </td>
                                            <td>
                                                <select @change="$store.cart.updateQuantity(key, +$event.target.value)"
                                                    class="select select-bordered select-sm w-full max-w-xs">
                                                    <template x-for="qty in 10" :key="qty">
                                                        <option :value="qty" x-text="qty"
                                                            :selected="qty === item.quantity"></option>
                                                    </template>
                                                </select>
                                            </td>
                                            <td>
                                                <span
                                                    x-text="`$${(parseFloat(item.price) * item.quantity).toFixed(2)}`"></span>
                                            </td>
                                            <th>
                                                <button class="btn btn-ghost btn-xs text-red-600"
                                                    @click="$store.cart.removeItem(key)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </th>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-end border-t border-gray-200 pt-8">
                            <div class="w-full max-w-lg space-y-4">
                                <template x-if="Object.keys($store.cart.items).length > 0">
                                    <div class="space-y-0.5 text-sm text-gray-700">
                                        <div class="flex justify-between">
                                            <div class="font-bold">Subtotal</div>
                                            <div x-text="`$${$store.cart.total}`"></div>
                                        </div>
                                        <div class="flex justify-between !text-base font-medium">
                                            <div class="font-bold">Total</div>
                                            <div x-text="`$${$store.cart.total}`"></div>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="Object.keys($store.cart.items).length > 0">
                                    <div class="flex justify-end">
                                        <a class="btn btn-neutral"
                                            href="{{ route('frontend.checkout.index') }}">Checkout</a>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


{{-- @push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        function checkoutComponent() {
            return {
                stripe: null,
                card: null, // rename from cardElement to card to match usage
                showShipping: false,
                showPayment: false,
                orderId: null,
                transactionId: null,
                isProcessing: false,
                shipping: {
                    name: '{{ auth()?->user()?->name ?? '' }}',
                    address: '',
                    city: '',
                    phone: '',
                },

                init() {
                    this.stripe = Stripe("{{ $stripe['public_key'] }}");
                    this.elements = this.stripe.elements();
                },

                async submitShipping() {
                    // Validate shipping form, then show Stripe payment form
                    this.showShipping = false;
                    this.showPayment = true;

                    // Wait for DOM update, then mount Stripe card
                    this.$nextTick(() => {
                        const style = {
                            base: {
                                fontSize: '16px',
                                color: '#32325d'
                            }
                        };
                        this.card = this.elements.create('card', {
                            style
                        });
                        this.card.mount(this.$refs.card);
                    });
                },

                async pay() {
                    this.isProcessing = true;

                    try {
                        // 1. Create a PaymentIntent (with amount from cart and shipping)
                        const paymentIntentRes = await axios.post('/checkout/payment-intent', {
                            shipping: this.shipping,
                            total: this.$store.cart.total,
                        });

                        const clientSecret = paymentIntentRes.data.client_secret;

                        // 2. Confirm the payment
                        const result = await this.stripe.confirmCardPayment(clientSecret, {
                            payment_method: {
                                card: this.card,
                                billing_details: {
                                    name: this.shipping.name
                                }
                            }
                        });

                        if (result.error) {
                            alert(result.error.message);
                            this.isProcessing = false;
                            return;
                        }

                        // 3. On success, create order + transaction
                        if (result.paymentIntent.status === 'succeeded') {
                            const confirmRes = await axios.post('/checkout/confirm', {
                                transaction_id: result.paymentIntent.id,
                            });

                            window.location.href = '/payment-complete';
                        }
                    } catch (error) {
                        console.error(error);
                        alert("Payment failed.");
                        this.isProcessing = false;
                    }
                }
            }
        }
    </script>
@endpush --}}
