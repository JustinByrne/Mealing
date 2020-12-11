@extends('layouts.auth')

@section('title', 'Forgotten Password')

@section('content')
<x-auth-card title="Forgotten Password">
    @if (session('status'))
        <x-alert type="info">
            {{ session('status') }}
        </x-alert>
    @endif

    <div class="text-center my-3">
        <form action="{{ route('password.email') }}" method="POST">
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
            <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>
                <div>
                    <x-button type="submit" class="mx-auto">Send link</x-button>
                </div>
            </div>
        </form>
    </div>
</x-auth-card>
@endsection