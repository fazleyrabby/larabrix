<div class="mb-4 grid gap-2 grid-cols-1 md:grid-cols-3">
    <article class="w-full rounded-lg border border-gray-100 bg-white p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Orders</p>
                <p class="text-2xl font-medium text-gray-900">{{ $orderCount }}</p>
            </div>

            <span class="rounded-full bg-blue-100 p-3 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </span>
        </div>

        <div class="mt-1 flex gap-1 text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>

            <p class="flex gap-2 text-xs">
                <span class="font-medium"> 67.81% </span>
                <span class="text-gray-500"> Since last week </span>
            </p>
        </div>
    </article>

    <article class="w-full rounded-lg border border-gray-100 bg-white p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Units Sold</p>
                <p class="text-2xl font-medium text-gray-900">{{ $itemCount }}</p>
            </div>

            <span class="rounded-full bg-blue-100 p-3 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </span>
        </div>

        <div class="mt-1 flex gap-1 text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>

            <p class="flex gap-2 text-xs">
                <span class="font-medium"> 67.81% </span>
                <span class="text-gray-500"> Since last week </span>
            </p>
        </div>
    </article>

    <article class="w-full rounded-lg border border-gray-100 bg-white p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Spent</p>
                <p class="text-2xl font-medium text-gray-900">${{ $total }}</p>
            </div>

            <span class="rounded-full bg-blue-100 p-3 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </span>
        </div>

        <div class="mt-1 flex gap-1 text-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
            </svg>

            <p class="flex gap-2 text-xs">
                <span class="font-medium"> 67.81% </span>
                <span class="text-gray-500"> Since last week </span>
            </p>
        </div>
    </article>
</div>

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
                    <th class="border border-gray-300">
                        <a class="text-info" href="{{ route('frontend.orders.show', $order->id) }}">{{ $order->transaction?->transaction_id }}</a>
                    </th>
                    {{-- <th class="border border-gray-300">{{ $order->order_number }}</th> --}}
                    <th class="border border-gray-300">{{ $order->payment_gateway }}</th>
                    <th class="border border-gray-300">
                        <table class="table table-xs border-gray-300">
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="border border-gray-300">{{ $item->quantity ?? 1 }} x
                                            {{ $item->product->title }}</td>
                                        <td class="border border-gray-300">{{ number_format($item->price ?? 0, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <table class="w-full text-xs border border-gray-300">
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
                        </table> --}}
                    </th>
                    <th class="border border-gray-300">{{ $order->total }}</th>
                    <th class="border border-gray-300">{{ $order->currency }}</th>
                    <th class="border border-gray-300">
                        <div class="badge badge-primary badge-xs">{{ $order->status }}</div>
                    </th>
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
