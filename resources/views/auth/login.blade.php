@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<x-auth-card>
    <form class="w-full max-w-sm" method="POST" action="{{ route('login.authenticate') }}">
        @csrf
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                    Email
                </label>
            </div>
            <div class="md:w-2/3">
                <x-input name="email" type="email" placeholder="Email" :error="$errors->has('email')"></x-input>
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="password">
                    Password
                </label>
            </div>
            <div class="md:w-2/3">
                <x-input name="password" type="password" placeholder="******************" :error="$errors->has('password')"></x-input>
            </div>
        </div>
        <div class="md:flex md:items-center">
            <div class="md:w-1/3"></div>
            <div class="md:w-2/3">
                <x-button type="submit">
                    Login
                </x-button>
            </div>
        </div>
    </form>
</x-auth-card>
@endsection