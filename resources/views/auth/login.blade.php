@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<x-auth-card title="Login">
    <form class="w-full max-w-sm" method="POST" action="/login" id="loginForm">
        @csrf
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                    Email
                </label>
            </div>
            <div class="md:w-2/3">
                <x-input name="email" type="email" placeholder="Email" :error="$errors->has('email')" value="{{ Request::old('email') }}" required></x-input>
                @error('email')
                    <p class="text-red-500 text-xs italic">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="password">
                    Password
                </label>
            </div>
            <div class="md:w-2/3">
                <x-input name="password" type="password" placeholder="******************" required></x-input>
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3"></div>
            <label class="md:w-2/3 block text-gray-500 font-bold">
                <input class="mr-2 leading-tight" type="checkbox" name="remember">
                <span class="text-sm">
                    Remember Me
                </span>
            </label>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3"></div>
            <div class="md:w-2/3 block text-gray-500 font-bold">
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 font-bold hover:text-blue-400">
                    Forgotten Password
                </a>
            </div>
        </div>
            <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <x-button type="submit">
                        Login
                    </x-button>
                    <a href="{{ route('register') }}" class="pl-4 text-blue-600 font-bold hover:text-blue-400">
                        Register
                    </a>
                </div>
            </div>
    </form>
</x-auth-card>
@endsection