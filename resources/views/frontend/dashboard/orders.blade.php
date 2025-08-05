<div class="overflow-x-auto lg:col-span-3 h-full">
    <h2 class="mb-2">Latest Orders</h2>
    <table class="table w-full text-xs border border-gray-300 mb-2">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300">#</th>
                <th class="border border-gray-300">Trx ID</th>
                {{-- <th class="border border-gray-300">Order</th> --}}
                <th class="border border-gray-300">Gateway</th>
                <th class="border border-gray-300">Items</th>
                <th class="border border-gray-300">Total</th>
                <th class="border border-gray-300">Currency</th>
                <th class="border border-gray-300">Status</th>
                <th class="border border-gray-300">Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $key => $order)
                <tr>
                    <th class="border border-gray-300">{{ $order->id }}</th>
                    <th class="border border-gray-300">{{ $order->transaction?->transaction_id }}</th>
                    {{-- <th class="border border-gray-300">{{ $order->order_number }}</th> --}}
                    <th class="border border-gray-300">{{ $order->payment_gateway }}</th>
                    <th class="border border-gray-300">
                        <table class="w-full text-xs border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-2 py-1 text-left">Title</th>
                                    <th class="border border-gray-300 px-2 py-1 text-left">Qty</th>
                                    <th class="border border-gray-300 px-2 py-1 text-left">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="border border-gray-300 px-2 py-1">{{ $item->product->title }}</td>
                                        <td class="border border-gray-300 px-2 py-1">{{ $item->quantity ?? 1 }}</td>
                                        <td class="border border-gray-300 px-2 py-1">{{ number_format($item->price ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </th>
                    <th class="border border-gray-300">{{ $order->total }}</th>
                    <th class="border border-gray-300">{{ $order->currency }}</th>
                    <th class="border border-gray-300"><div class="badge badge-primary badge-xs">{{ $order->status }}</div></th>
                    <th class="border border-gray-300">{{ $order->created_at->format('M d, Y h:i A') }}</th>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray-100">
                <th class="border border-gray-300">#</th>
                <th class="border border-gray-300">Trx ID</th>
                {{-- <th class="border border-gray-300">Order</th> --}}
                <th class="border border-gray-300">Gateway</th>
                <th class="border border-gray-300">Items</th>
                <th class="border border-gray-300">Total</th>
                <th class="border border-gray-300">Currency</th>
                <th class="border border-gray-300">Status</th>
                <th class="border border-gray-300">Created At</th>
            </tr>
        </tfoot>
    </table>
    {{ $orders->links('pagination::tailwind') }}
</div>
