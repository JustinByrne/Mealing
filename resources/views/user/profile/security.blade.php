@extends('layouts.app')

@section('title', 'My Security')

@include('user.profile.sidebar')

@section('content')
    <h1 class="font-sans break-normal text-gray-900 pt-6 pb-4 text-xl">Security Settings</h1>
    <hr class="border-b border-gray-400 mb-3">

    <h2 class="font-sans break-normal text-gray-900 pt-3 pb-3 text-base font-bold">Multifactor Authentication</h2>

    @if (session('status') == 'two-factor-authentication-enabled')
        <x-alert type="info">
            Two factor authentication has been enabled.
        </x-alert>
    @endif

    @if (session('status') == 'two-factor-authentication-disabled')
        <x-alert type="warn">
            Two factor authentication has been disabled.
        </x-alert>
    @endif
    

    <form action="/user/two-factor-authentication" method="POST" class="mt-3">
        @csrf
        @if ($user->get2faEnabled())
            <div x-data="{ isOpen: false }">
                <x-inputs.button @click="isOpen = true" type="button"><i class="fas fa-qrcode"></i> Show QR Code</x-inputs.button>
                <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full z-50" style="background-color: rgba(0,0,0,.5);" x-show="isOpen">
                <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0" @click.away="isOpen = false">
                    <div class="flex items-center justify-between pb-6">
                        <h2 class="font-sans break-normal text-gray-900 text-base font-bold">QR Code</h2>
                        <span>
                            <button @click="isOpen = false" type="button" class="flex-initial"><i class="fas fa-times"></i></button>
                        </span>
                    </div>
                    <div class="pb-3 px-4">
                        {!! $user->twoFactorQrCodeSvg() !!}
                    </div>
                </div>
            </div>
            @method('delete')
            <x-inputs.button type="submit">Disable</x-inputs.button>
            <div class="mt-4" x-data="{ isOpen: false }">
                <div class="text-sm font-light leading-relaxed mt-0 mb-2 text-lightGray-800">
                    <p class="cursor-pointer hover:text-orange-500 hover:underline" @click="isOpen = true">Show Recovery Codes</p>
                </div>
                <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full z-50" style="background-color: rgba(0,0,0,.5);" x-show="isOpen">
                    <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0" @click.away="isOpen = false">
                        <div class="flex items-center justify-between pb-6">
                            <h2 class="font-sans break-normal text-gray-900 text-base font-bold">Recovery Codes</h2>
                            <span>
                                <button @click="isOpen = false" type="button" class="flex-initial"><i class="fas fa-times"></i></button>
                            </span>
                        </div>
                        <div class="text-md font-light leading-relaxed mt-0 mb-2 px-4 text-lightGray-800">
                            <ol class="list-decimal px-4 space-y-1">
                                @foreach (Auth::user()->getRecoveryCodes() as $code)
                                    <li>{{ $code }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p class="text-base font-light leading-normal mt-0 mb-1">2FA is currently disabled</p>
            <x-inputs.button type="submit">Enable</x-inputs.button>
        @endif
    </form>
@endsection