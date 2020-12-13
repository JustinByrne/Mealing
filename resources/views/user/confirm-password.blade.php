@extends('layouts.app')

@section('title', 'Confirm Password')

@section('content')
    <div class="md:w-1/2 md:mx-auto">
        <form action="{{ route('password.confirm') }}" method="POST">
            @csrf
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
            <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <x-inputs.button type="submit">
                        Confirm
                    </x-inputs.button>
                </div>
            </div>
        </form>
    </div>
@endsection