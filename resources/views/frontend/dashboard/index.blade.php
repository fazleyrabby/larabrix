@extends('frontend.app')

@section('content')
    <section class="page-container">
        <div class="mx-auto max-w-fit px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <header>
                <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Dashboard</h2>
            </header>
            
            
            <x-sidebar>
                @include('frontend.dashboard.orders')
            </x-sidebar>
        </div>
    </section>
@endsection
