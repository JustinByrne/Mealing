@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<x-auth-card title="Reset Password">
    @if (session('status'))
        <x-alert type="info">
            {{ session('status') }}
        </x-alert>
    @endif

    <div class="text-center my-3">
        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <x-input type="hidden" name="token" value="{{ request()->route('token') }}" required />
            
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                        Email
                    </label>
                </div>
                <div class="md:w-2/3">
                    <x-input name="email" type="email" placeholder="Email" :error="$errors->has('email')" value="{{ Request::old('email', request()->get('email')) }}" required></x-input>
                    @error('email')
                        <p class="text-red-500 text-xs italic text-left">
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
                    <x-input name="password" type="password" placeholder="******************" :error="$errors->has('password')" required></x-input>
                    @error('password')
                        <p class="text-red-500 text-xs italic text-left">
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
                    <x-input name="password_confirmation" type="password" placeholder="******************" :error="$errors->has('password')" required></x-input>
                </div>
            </div>
            
            <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3 text-left">
                    <x-button type="submit" class="mx-auto">Reset Password</x-button>
                </div>
            </div>
        </form>
    </div>
</x-auth-card>
@endsection