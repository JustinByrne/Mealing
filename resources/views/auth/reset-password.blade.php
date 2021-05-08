@extends('auth.layout')

@section('title', 'Reset Password')

@section('content')
<div class="p-3">
    @if (session('status'))
        <div class="bg-blue-400 bg-opacity-20 text-blue-700 border-l-4 border-blue-400 py-3 px-4 dark:bg-opacity-40 dark:text-blue-300">
            <i class="fas fa-info-circle mr-1"></i> {{ session('status') }}
        </div>
    @endif

    <div>
        <form action="{{ route('password.update') }}" method="POST" class="space-y-3">
            @csrf

            <input type="hidden" name="token" value="{{ request()->route('token') }}" />

            <div class="grid grid-cols-1 lg:grid-cols-3 items-center">
                <label for="email" class="hidden lg:block dark:text-gray-200">
                    Email
                </label>
                <input type="email" placeholder="Email" id="email" name="email" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
            </div>
            @error('email')
                <p class="text-red-500 text-xs italic text-left">
                    {{ $message }}
                </p>
            @enderror

            <div class="grid grid-cols-1 lg:grid-cols-3 items-center">
                <label for="password" class="hidden lg:block dark:text-gray-200">
                    Password
                </label>
                <input type="password" placeholder="Password" id="password" name="password" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 items-center">
                <label for="password_confirmation" class="hidden lg:block dark:text-gray-200">
                    Confirm
                </label>
                <input type="password" placeholder="Password" id="password_confirmation" name="password_confirmation" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 lg:gap-3 items-center">
                <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-600 text-white hover:bg-green-500">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection