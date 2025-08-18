@extends('frontend.app')

@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <header>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Details {{ $order->order_number }}</h2>
            </header>
            <x-sidebar>
                <div class="grid gap-8">
                    <!-- Left Column: Order Details -->
                    <div class="lg:col-span-2 overflow-x-auto border border-base-content bg-base-100">
                        <table class="table w-full">
                            <thead>
                                <tr class="table-section-header">
                                    <th colspan="2">Order Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Order Number</th>
                                    <td>{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span
                                            class="badge {{ $order->status->value === 'pending' ? 'badge-warning' : 'badge-success' }}">
                                            {{ ucfirst($order->status->value) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <td>
                                        <span
                                            class="badge {{ $order->payment_status === 'pending' ? 'badge-warning' : 'badge-success' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <td>{{ strtoupper($order->payment_gateway) }}</td>
                                </tr>
                                <tr>
                                    <th>Transaction ID</th>
                                    <td>{{ $order->transaction->transaction_id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>{{ $order->currency }} {{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Discount</th>
                                    <td>{{ $order->currency }} {{ number_format($order->discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Tax</th>
                                    <td>{{ $order->currency }} {{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping Cost</th>
                                    <td>{{ $order->currency }} {{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>{{ $order->currency }} {{ number_format($order->total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ \Carbon\Carbon::parse($order->updated_at)->format('M d, Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Right Column: Shipping Address and Order Items -->
                    <div class="lg:col-span-2 space-y-8">
                        <div class="border border-base-content bg-base-100">
                            <!-- Shipping Address -->
                            <table class="table w-full bg-base-100">
                                <thead>
                                    <tr class="table-section-header">
                                        <th colspan="2">Shipping Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $shipping = $order->shipping_address;
                                        if (is_string($shipping)) {
                                            $shipping = json_decode($shipping);
                                        }
                                    @endphp

                                    @if ($shipping && (is_object($shipping) || is_array($shipping)))
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $shipping->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>City</th>
                                            <td>{{ $shipping->city ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $shipping->phone ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $shipping->address ?? 'N/A' }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <th>Address</th>
                                            <td class="text-error">No shipping address provided.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>


                        <div class="overflow-x-auto border border-base-content bg-base-100">
                            <table class="table w-full bg-base-100">
                                <thead>
                                    <tr class="table-section-header">
                                        <th colspan="4">Order Items</th>
                                    </tr>
                                    @if ($order->items->isNotEmpty())
                                        <tr>
                                            <th>Product</th>
                                            <th>Variant</th>
                                            <th class="numeric">Quantity</th>
                                            <th class="numeric">Price</th>
                                        </tr>
                                    @endif
                                </thead>
                                <tbody>
                                    @if ($order->items->isNotEmpty())
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td>{{ $item->name ?? 'Unknown Product' }}</td>
                                                <td>
                                                    @if ($item->variant && $item->variant->attributeValues->isNotEmpty())
                                                        {{ $item->variant->attributeValues->map(fn($av) => ($av->attribute->title ?? 'Attribute ' . $av->attribute_id) . ': ' . $av->title)->implode(', ') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="numeric">{{ $item->quantity ?? 0 }}</td>
                                                <td class="numeric">{{ $order->currency }}
                                                    {{ number_format($item->price ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-error">No items found in this order.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>

                    @include('frontend.dashboard.orders.timeline')
                </div>
            </x-sidebar>
        </div>
    </section>
@endsection
