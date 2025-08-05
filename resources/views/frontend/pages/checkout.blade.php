@extends('frontend.app')
@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <div class="mx-auto max-w-6xl" x-data="checkoutComponent()" x-init="init()">
                <header class="text-center">
                    <h1 class="text-xl font-bold text-gray-900 sm:text-3xl">Checkout</h1>
                </header>

                <div class="mt-8 max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Left: Shipping Form + Payment (2/3) -->
                    <div class="lg:col-span-2">
                        <!-- Shipping Form -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Shipping Information</h2>
                            <form @submit.prevent="submitShipping" class="space-y-4">
                                <div>
                                    <label class="label"><span class="label-text">Full Name</span></label>
                                    <input type="text" x-model="shipping.name" required placeholder="John Doe"
                                        class="input input-bordered w-full" />
                                </div>

                                <div>
                                    <label class="label"><span class="label-text">Address</span></label>
                                    <input type="text" x-model="shipping.address" required placeholder="123 Main St"
                                        class="input input-bordered w-full" />
                                </div>

                                <div>
                                    <label class="label"><span class="label-text">City</span></label>
                                    <input type="text" x-model="shipping.city" required placeholder="New York"
                                        class="input input-bordered w-full" />
                                </div>

                                <div>
                                    <label class="label"><span class="label-text">Phone</span></label>
                                    <input type="text" x-model="shipping.phone" required placeholder="+1 555 123 4567"
                                        class="input input-bordered w-full" />
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="btn btn-primary w-full">Continue to Payment</button>
                                </div>
                            </form>
                        </div>

                        <!-- Stripe Payment -->
                        <div x-show="showPayment" x-cloak class="mt-6">
                            <div x-ref="card" id="card-element" class="border p-4 rounded"></div>
                            <button type="button" @click="pay" :disabled="isProcessing"
                                class="mt-4 rounded px-4 py-2 text-white w-full"
                                :class="isProcessing ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-500'">
                                <span x-show="!isProcessing">Pay Now</span>
                                <span x-show="isProcessing">Processing...</span>
                            </button>
                        </div>
                    </div>

                    <!-- Right: Cart Summary Table (1/3) -->
                    <div x-data x-init class="overflow-x-auto rounded border border-gray-200 h-max">
                        <h2 class="text-lg font-semibold mb-4 px-4">Summary</h2>
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left">Image</th>
                                    <th class="px-4 py-2 text-left">Title</th>
                                    <th class="px-4 py-2 text-center">Qty</th>
                                    <th class="px-4 py-2 text-center">Price</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-if="Object.keys($store.cart.items).length === 0">
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-500 py-4">Your cart is empty.</td>
                                    </tr>
                                </template>

                                <template x-for="(item, key) in $store.cart.items" :key="key">
                                    <tr>
                                        <td class="px-4 py-2">
                                            <img :src="item.image" alt=""
                                                class="h-12 w-12 object-cover rounded" />
                                        </td>
                                        <td class="px-4 py-2 text-gray-900" x-text="item.title"></td>
                                        <td class="px-4 py-2 text-center text-gray-700" x-text="item.quantity"></td>
                                        <td class="px-4 py-2 text-center text-gray-700" x-text="item.price * item.quantity">
                                        </td>
                                    </tr>
                                </template>

                                <!-- Subtotal -->
                                <template x-if="Object.keys($store.cart.items).length > 0">
                                    <tr class="bg-gray-50">
                                        <td colspan="3" class="px-4 py-3 text-right font-medium text-gray-700">Subtotal
                                        </td>
                                        <td class="px-4 py-3 text-center font-medium text-gray-700"
                                            x-text="$store.cart.total"></td>
                                    </tr>
                                </template>

                                <!-- Total -->
                                <template x-if="Object.keys($store.cart.items).length > 0">
                                    <tr class="bg-gray-100 font-semibold text-gray-900">
                                        <td colspan="3" class="px-4 py-3 text-right">Total</td>
                                        <td class="px-4 py-3 text-center" x-text="$store.cart.total"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
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
@endpush
