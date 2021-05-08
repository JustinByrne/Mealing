@extends('auth.layout')

@section('title', 'Login')

@section('content')
<form action="/login" method="POST" class="p-3 space-y-3">
    @csrf
    @if (session('message'))
        <div class="bg-red-400 bg-opacity-20 text-red-700 border-l-4 border-red-400 py-3 px-4 dark:bg-opacity-40 dark:text-red-300">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('message') }}
        </div>
    @endif
    @error('email')
        <p class="text-red-500 italic text-xs font-light">
            {{ $message }}
        </p>
    @enderror
    <div class="grid grid-cols-1 lg:grid-cols-3 items-center">
        <label for="email" class="hidden lg:block dark:text-gray-200">
            Email
        </label>
        <input type="email" placeholder="Email" id="email" name="email" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 items-center">
        <label for="password" class="hidden lg:block dark:text-gray-200">
            Password
        </label>
        <input type="password" placeholder="Password" id="password" name="password" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 items-center">
        <div class="lg:col-start-2 col-span-2">
            <a href="{{ route('password.request') }}" class="text-sm hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                Forgotten My Password
            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 items-center">
        <div class="lg:col-start-2">
            <p class="dark:text-gray-200 space-x-2">
                <input type="checkbox" name="remember" id="remember" class="rounded text-green-600 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200 dark:focus:bg-green-600">
                <label for="remember">
                    Remember Me
                </label>
            </p>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 lg:gap-3 items-center">
        <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-600 text-white hover:bg-green-500">
            Login
        </button>
        <a href="{{ route('register') }}" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-gray-400 text-white hover:bg-gray-300 text-center">
            Register
        </a>
    </div>
</form>
@endsection