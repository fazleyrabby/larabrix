@extends('frontend.app')

@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-fit px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <header>
                <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Transactions</h2>
            </header>
            {{-- <div class="mt-4 lg:mt-8 lg:grid lg:grid-cols-4 lg:items-stretch lg:gap-8">
                @include('frontend.partials.sidebar')
                
            </div> --}}
            <x-sidebar>
                <div class="overflow-x-auto lg:col-span-3 h-full">
                    <table class="table w-full text-xs border border-gray-300 mb-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300">#</th>
                                <th class="border border-gray-300">Trx ID</th>
                                <th class="border border-gray-300">Order ID</th>
                                <th class="border border-gray-300">Gateway</th>
                                <th class="border border-gray-300">Total</th>
                                <th class="border border-gray-300">Currency</th>
                                <th class="border border-gray-300">Status</th>
                                <th class="border border-gray-300">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $key => $transaction)
                                <tr>
                                    <th class="border border-gray-300">{{ $transaction->id }}</th>
                                    <th class="border border-gray-300">{{ $transaction->transaction_id }}</th>
                                    <th class="border border-gray-300">{{ $transaction->order_id }}</th>
                                    <th class="border border-gray-300">{{ $transaction->gateway }}</th>
                                    <th class="border border-gray-300">{{ $transaction->amount }}</th>
                                    <th class="border border-gray-300">{{ $transaction->currency }}</th>
                                    <th class="border border-gray-300">
                                        <div class="badge badge-primary badge-xs">{{ $transaction->status }}</div>
                                    </th>
                                    <th class="border border-gray-300">
                                        {{ $transaction->created_at->format('M d, Y h:i A') }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300">#</th>
                                <th class="border border-gray-300">Trx ID</th>
                                <th class="border border-gray-300">Order ID</th>
                                <th class="border border-gray-300">Gateway</th>
                                <th class="border border-gray-300">Total</th>
                                <th class="border border-gray-300">Currency</th>
                                <th class="border border-gray-300">Status</th>
                                <th class="border border-gray-300">Created At</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $transactions->links('pagination::tailwind') }}
                </div>
            </x-sidebar>
        </div>
    </section>
@endsection
