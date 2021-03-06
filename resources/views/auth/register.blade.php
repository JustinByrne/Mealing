@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <x-auth-card title="Register">
        <form class="w-full max-w-sm" method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf
            <input type='hidden' name='recaptcha_token' id='recaptcha_token'>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                        Name
                    </label>
                </div>
                <div class="md:w-2/3">
                    <x-inputs.text name="name" type="text" placeholder="Name" :error="$errors->has('name')" value="{{ Request::old('name') }}" required></x-inputs.text>
                    @error('name')
                        <p class="text-red-500 text-xs italic">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                        Email
                    </label>
                </div>
                <div class="md:w-2/3">
                    <x-inputs.text name="email" type="email" placeholder="Email" :error="$errors->has('email')" value="{{ Request::old('email') }}" required></x-inputs.text>
                    @error('email')
                        <p class="text-red-500 text-xs italic">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-password">
                        Password
                    </label>
                </div>
                <div class="md:w-2/3">
                    <x-inputs.text name="password" type="password" placeholder="******************" :error="$errors->has('password')" required></x-inputs.text>
                    @error('password')
                        <p class="text-red-500 text-xs italic">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-password">
                        Confirm
                    </label>
                </div>
                <div class="md:w-2/3">
                    <x-inputs.text name="password_confirmation" type="password" placeholder="******************" :error="$errors->has('password')" required></x-inputs.text>
                </div>
            </div>
            <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <x-inputs.button type="submit">
                        {{ __('Register') }}
                    </x-inputs.button>
                    <a href="{{ route('login') }}" class="pl-4 text-blue-600 font-bold hover:text-blue-400">
                        {{ __('Login') }}
                    </a>
                </div>
            </div>
        </form>
    </x-auth-card>
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.site_key') }}"></script>
    <script>
        grecaptcha.ready(function() {

            document.getElementById('registerForm').addEventListener("submit", function(event) {
                event.preventDefault();

                grecaptcha.execute('{{ config('recaptcha.site_key') }}', {action: 'register'})
                    .then(function(token) {
                        document.getElementById("recaptcha_token").value = token;
                        document.getElementById('registerForm').submit();
                });
            });

        });
    </script>
@endsection