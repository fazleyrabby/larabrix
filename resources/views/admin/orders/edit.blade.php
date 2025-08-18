@extends('admin.layouts.app')
@section('title', 'Order View')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Order Edit
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <form class="w-100" action="{{ route('admin.orders.update', $order->id) }}" method="post">
                        @method('put')
                        @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order preview</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
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
                                        <select type="text" class="form-select" name="order_status" id="select-users" value="">
                                            @foreach (\App\Enums\OrderStatus::cases() as $status)
                                                <option value="{{ $status->value }}" @selected($order->status->value == $status->value)>
                                                    {{ ucfirst($status->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <td>
                                         <select type="text" class="form-select" name="payment_status" id="select-users" value="">
                                            <option value="pending" @selected($order->payment_status == 'pending')>Pending</option>
                                            <option value="paid" @selected($order->payment_status == 'paid')>Paid</option>
                                        </select>
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
                        <table class="table table-bordered">
                                <thead>
                                    <tr class="table-section-header">
                                        <th colspan="2">Customer Info</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Customer Name</th>
                                        <td class="text-error">{{ $order->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Email</th>
                                        <td class="text-error">{{ $order->user->email }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
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
                            <h3>Order Items</h3>
                            <table class="table table-bordered">
                                <thead>
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
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
