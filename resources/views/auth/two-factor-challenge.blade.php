@extends('layouts.auth')

@section('title', 'Authenticate Your Account')

@section('content')
<x-auth-card title="Authenticate Your Account">
    <p class="text-sm font-light leading-relaxed mt-0 mb-4 text-lightGray-800">
        Enter your 6 digit code from your two factor authenticator app.
    </p>
    <form class="w-full max-w-sm" method="POST" action="{{ route('two-factor.login') }}">
        @csrf
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="code">
                    Code
                </label>
            </div>
            <div class="md:w-2/3">
                <x-inputs.text name="code" type="code" placeholder="X X X X X X" :error="$errors->has('code')" value="{{ Request::old('code') }}" required autofocus></x-inputs.text>
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
                <x-inputs.button type="submit">
                    Authenticate
                </x-inputs.button>
            </div>
        </div>
    </form>
</x-auth-card>
@endsection