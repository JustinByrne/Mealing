@extends('layouts.auth')

@section('title', 'Authenticate Your Account')

@section('content')
<x-auth-card title="Authenticate Your Account">
    <form class="w-full max-w-sm" method="POST" action="{{ route('two-factor.login') }}">
        @csrf
        <div x-data="{ code: true }">
            <div x-show="code">
                <p class="text-sm font-light leading-relaxed mt-0 mb-4 text-lightGray-800">
                    Enter your 6 digit code from your two factor authenticator app.
                </p>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="code">
                            Code
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <x-inputs.text name="code" type="code" placeholder="X X X X X X" :error="$errors->has('code')" value="{{ Request::old('code') }}" autofocus></x-inputs.text>
                        @error('code')
                            <p class="text-red-500 text-xs italic">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <div class="grid justify-items-end w-full pb-3">
                    <div>
                        <a class="text-sm cursor-pointer hover:text-orange-500 hover:underline" @click="code = false">
                            Use Recovery Code
                        </a>
                    </div>
                </div>
            </div>

            <div x-show="!code">
                <p class="text-sm font-light leading-relaxed mt-0 mb-4 text-lightGray-800">
                    Enter your recovery code.
                </p>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="code">
                            Recovery Code
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <x-inputs.text name="recovery_code" type="recovery_code" placeholder="XXXXXXXXXX-XXXXXXXXXX" :error="$errors->has('recovery_code')" value="{{ Request::old('recovery_code') }}" autofocus></x-inputs.text>
                        @error('recovery_code')
                            <p class="text-red-500 text-xs italic">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <div class="grid justify-items-end w-full pb-3">
                    <div>
                        <a class="text-sm cursor-pointer hover:text-orange-500 hover:underline" @click="code = true">
                            Use Authenticator Code
                        </a>
                    </div>
                </div>
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