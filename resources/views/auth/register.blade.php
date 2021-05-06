@extends('auth.layout')

@section('title', 'Register')

@section('content')
<form class="p-3 space-y-3" method="POST" action="{{ route('register') }}" id="registerForm">
    @csrf
    <input type='hidden' name='recaptcha_token' id='recaptcha_token'>

    @error('name')
        <p class="text-red-500 italic text-xs font-light">
            {{ $message }}
        </p>
    @enderror

    @error('email')
        <p class="text-red-500 italic text-xs font-light">
            {{ $message }}
        </p>
    @enderror

    @error('password')
        <p class="text-red-500 italic text-xs font-light">
            {{ $message }}
        </p>
    @enderror

    <div class="grid grid-cols-1 lg:grid-cols-3 items-center">
        <label for="name" class="hidden lg:block dark:text-gray-200">
            Name
        </label>
        <input type="text" placeholder="Name" id="name" name="name" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
    </div>

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
        <input type="password" placeholder="********" id="password" name="password" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 items-center">
        <label for="password_confirmation" class="hidden lg:block dark:text-gray-200">
            Confirm
        </label>
        <input type="password" placeholder="********" id="password_confirmation" name="password_confirmation" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 lg:gap-3 items-center">
        <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-600 text-white hover:bg-green-500">
            Register
        </button>
        <a href="{{ route('login') }}" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-gray-400 text-white hover:bg-gray-300 text-center">
            Login
        </a>
    </div>
</form>

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