@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<x-auth-card title="Login">
    <form class="w-full max-w-sm" method="POST" action="{{ route('two-factor.login') }}">
        @csrf
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="code">
                    Code
                </label>
            </div>
            <div class="md:w-2/3">
                <x-input name="code" type="code" placeholder="code" :error="$errors->has('code')" value="{{ Request::old('code') }}" required></x-input>
                @error('code')
                    <p class="text-red-500 text-xs italic">
                        {{ $message }}
                    </p>
                @enderror
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