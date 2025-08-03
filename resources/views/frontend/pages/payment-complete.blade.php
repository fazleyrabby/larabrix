@extends('frontend.app')

@section('content')
<section class="page-container flex items-center justify-center min-h-[60vh]">
    <div class="text-center bg-white shadow-md rounded-2xl p-10 max-w-md w-full border border-gray-200">
        <div class="text-5xl mb-4">🎉</div>
        <h1 class="text-2xl font-semibold text-gray-800 mb-2">Thank you for your order!</h1>
        <p class="text-gray-600 mb-6">We're processing your order and will notify you when it's on the way.</p>
        <a href="{{ route('user.dashboard') }}" 
           class="inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full text-sm transition">
            Go to Dashboard
        </a>
    </div>
</section>
@endsection