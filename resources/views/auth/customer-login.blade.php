@extends('frontend.app')

@section('content')
<section class="page-container mx-auto max-w-md py-12">
    <form action="{{ route('user.login') }}" method="POST" autocomplete="off" novalidate class="space-y-6 bg-white p-8 shadow rounded">
        @csrf

        <h2 class="text-2xl font-bold mb-4 text-center">Sign In</h2>

        {{-- Email Field --}}
        <div>
            <label class="block text-sm font-medium mb-1">Email address</label>
            <input type="email" name="email" class="w-full input" placeholder="your@email.com" value="{{ old('email', $user->email ?? '') }}">
            @error('email')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        {{-- Password Field --}}
        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <div class="relative">
                <input type="password" name="password" class="w-full input pr-10" placeholder="Your password" value="{{ old('password', $user->password ?? '') }}">
                <span class="absolute inset-y-0 right-2 flex items-center">
                    <a href="#" class="text-gray-500 hover:text-gray-700" title="Show password">
                        <!-- Eye icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>
                </span>
            </div>
            @error('password')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center">
            <input type="checkbox" name="remember" class="form-check-input mr-2" id="remember-me">
            <label for="remember-me" class="text-sm text-gray-700">Remember me on this device</label>
        </div>

        {{-- Submit Button --}}
        <div>
            <button type="submit" class="btn btn-primary w-full">Sign In</button>
        </div>
    </form>
</section>
@endsection