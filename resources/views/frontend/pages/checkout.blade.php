@extends('frontend.app')
@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <div class="mx-auto max-w-6xl" x-data="checkoutComponent()" x-init="init()">
                <header class="text-center">
                    <h1 class="text-xl font-bold text-gray-900 sm:text-3xl">Checkout</h1>
                </header>

                <div class="mt-8 max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
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
                        
                        <div x-show="showPaymentOptions" x-cloak class="mt-6">
                            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Select a Payment Method</h2>
                            <div class="space-y-4">
                                <div class="bg-white p-4 rounded-lg shadow flex items-center gap-4 cursor-pointer"
                                    :class="selectedPayment === 'stripe' ? 'border-2 border-blue-500' : ''"
                                    @click="selectedPayment = 'stripe'">
                                    <input type="radio" name="payment_method" value="stripe" x-model="selectedPayment" class="radio radio-primary" />
                                    <div class="flex-grow">
                                        <h3 class="font-bold">Credit/Debit Card (Stripe)</h3>
                                        <p class="text-sm text-gray-500">Pay securely with your credit or debit card.</p>
                                    </div>
                                    <img src="https://stripe.com/img/payments/elements-examples/mastercard.svg" alt="Stripe" class="h-6">
                                </div>
        
                                <div class="bg-white p-4 rounded-lg shadow flex items-center gap-4 cursor-pointer"
                                    :class="selectedPayment === 'paypal' ? 'border-2 border-blue-500' : ''"
                                    @click="selectedPayment = 'paypal'">
                                    <input type="radio" name="payment_method" value="paypal" x-model="selectedPayment" class="radio radio-primary" />
                                    <div class="flex-grow">
                                        <h3 class="font-bold">PayPal</h3>
                                        <p class="text-sm text-gray-500">Pay with your PayPal account.</p>
                                    </div>
                                    <img src="https://www.paypalobjects.com/paypal-ui/logos/svg/paypal-mark.svg" alt="PayPal" class="h-6">
                                </div>
        
                                <div class="bg-white p-4 rounded-lg shadow flex items-center gap-4 cursor-pointer"
                                    :class="selectedPayment === 'cod' ? 'border-2 border-blue-500' : ''"
                                    @click="selectedPayment = 'cod'">
                                    <input type="radio" name="payment_method" value="cod" x-model="selectedPayment" class="radio radio-primary" />
                                    <div class="flex-grow">
                                        <h3 class="font-bold">Cash on Delivery</h3>
                                        <p class="text-sm text-gray-500">Pay with cash when your order is delivered.</p>
                                    </div>
                                </div>
                            </div>
        
                            <div x-show="selectedPayment === 'stripe'" x-cloak class="mt-6">
                                <div class="bg-white p-6 rounded-lg shadow">
                                    <h3 class="font-semibold text-lg mb-4">Card Details</h3>
                                    <div x-ref="card" id="card-element" class="border p-4 rounded"></div>
                                </div>
                            </div>

                            <button @click="processPayment" :disabled="isProcessing"
                                class="mt-6 btn btn-neutral w-full"
                                :class="isProcessing ? 'bg-gray-400 cursor-not-allowed' : 'hover:opacity-60'">
                                <span x-show="!isProcessing">Complete Order</span>
                                <span x-show="isProcessing">Processing...</span>
                            </button>
                        </div>
                    </div>
        
                    <div x-data x-init class="overflow-x-auto rounded border border-gray-200 h-max">
                        <h2 class="text-lg font-semibold px-4 py-2">Summary</h2>
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
        
                                <template x-if="Object.keys($store.cart.items).length > 0">
                                    <tr class="bg-gray-50">
                                        <td colspan="3" class="px-4 py-3 text-right font-medium text-gray-700">Subtotal
                                        </td>
                                        <td class="px-4 py-3 text-center font-medium text-gray-700"
                                            x-text="$store.cart.total"></td>
                                    </tr>
                                </template>
        
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
                elements: null,
                card: null,
                showPaymentOptions: false,
                selectedPayment: 'stripe', // Default to stripe
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
                    if (
                        !this.shipping.name ||
                        !this.shipping.address ||
                        !this.shipping.city ||
                        !this.shipping.phone
                    ) {
                        Alpine.store('toast').show(false, 'Please fill out all required fields.');
                        return;
                    }
        
                    this.showPaymentOptions = true;
        
                    // Wait for DOM update, then mount Stripe card
                    this.$nextTick(() => {
                        if(this.selectedPayment === 'stripe' && !this.card) {
                            const style = {
                                base: {
                                    fontSize: '16px',
                                    color: '#32325d'
                                }
                            };
                            this.card = this.elements.create('card', { style });
                            this.card.mount(this.$refs.card);
                        }
                    });
                },
        
                async processPayment() {
                    this.isProcessing = true;
                    if(this.selectedPayment === 'stripe') {
                        this.payWithStripe();
                    } else if (this.selectedPayment === 'paypal') {
                        // Handle PayPal logic (e.g., redirect to PayPal or a modal)
                        // For this example, we'll just show a message.
                        Alpine.store('toast').show(false, "PayPal integration is not yet implemented.");
                        this.isProcessing = false;
                    } else if (this.selectedPayment === 'cod') {
                        // Handle Cash on Delivery logic
                        this.payWithCOD();
                    }
                },
        
                async payWithStripe() {
                    try {
                        const paymentIntentRes = await axios.post('/checkout/payment-intent', {
                            shipping: this.shipping,
                            total: this.$store.cart.total,
                        });
        
                        const clientSecret = paymentIntentRes.data.client_secret;
        
                        const result = await this.stripe.confirmCardPayment(clientSecret, {
                            payment_method: {
                                card: this.card,
                                billing_details: {
                                    name: this.shipping.name
                                }
                            }
                        });
        
                        if (result.error) {
                            Alpine.store('toast').show(false, result.error.message);
                            this.isProcessing = false;
                            return;
                        }
        
                        if (result.paymentIntent.status === 'succeeded') {
                            await axios.post('/checkout/confirm', {
                                transaction_id: result.paymentIntent.id,
                                payment_method: 'stripe',
                            });
        
                            window.location.href = '/payment-complete';
                        }
                    } catch (error) {
                        console.error(error);
                        Alpine.store('toast').show(false, "Payment failed.");
                        this.isProcessing = false;
                    }
                },
        
                async payWithCOD() {
                    try {
                        await axios.post('/checkout/confirm', {
                            transaction_id: 'cod-' + new Date().getTime(),
                            payment_method: 'cod',
                            shipping: this.shipping,
                            total: this.$store.cart.total,
                        });
        
                        window.location.href = '/payment-complete';
                    } catch (error) {
                        console.error(error);
                        Alpine.store('toast').show(false, "Failed to place order.");
                        this.isProcessing = false;
                    }
                }
            }
        }
    </script>
@endpush