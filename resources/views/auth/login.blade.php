@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<x-auth-card title="Login">
    @if (session('message'))
        <x-alert type="warn">
            {{ session('message') }}
        </x-alert>
    @endif
    <form class="w-full max-w-sm" method="POST" action="/login" id="loginForm">
        @csrf
        <div class="space-y-4 p-2">
            <div class="grid grid-cols-1 md:grid-cols-4 md:items-center">
                <div>
                    <label for="email" class="font-light text-sm md:text-base">
                        Email
                    </label>
                </div>
                <div class="md:col-span-3">
                    <x-inputs.text type="email" name="email" id="email" placeholder="Email" :error="$errors->has('email')" required />
                    @error('email')
                        <p class="text-red-500 italic text-xs font-light">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 md:items-center">
                <div>
                    <label for="password" class="font-light text-sm md:text-base">
                        Password
                    </label>
                </div>
                <div class="md:col-span-3">
                    <x-inputs.text type="password" name="password" id="password" placeholder="********" required />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4">
                <div></div>
                <div class="md:col-span-3">
                    <label for="remember" class="text-sm font-light items-center md:text-base">
                        <input type="checkbox" name="remember" id="remember" class="text-green-600">
                        <span>
                            Remember Me
                        </span>
                    </label>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4">
                <div></div>
                <div class="md:col-span-3">
                    <a href="{{ route('password.request') }}" class="text-sm font-light text-blue-500 hover:text-blue-800">
                        Forgotten My Password
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4">
                <div>
                </div>
                <div class="space-y-2 md:col-span-3">
                    <x-inputs.button type="submit">
                        Login
                    </x-inputs.button>
                    <x-inputs.link href="{{ route('register') }}">
                        Register
                    </x-inputs.link>
                </div>
            </div>
        </div>
    </form>
</x-auth-card>
@endsection