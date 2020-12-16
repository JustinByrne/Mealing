@extends('layouts.app')

@section('title', $user->getFullName() . ' - Profile Security')

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
            <div x-data="{ open: false }">
                <x-inputs.button @click="open = true" type="button"><i class="fas fa-qrcode"></i> Show QR Code</x-inputs.button>
                <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full" style="background-color: rgba(0,0,0,.5);" x-show="open">
                <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0" @click.away="open = false">
                    <div class="pb-3">
                        {!! $user->twoFactorQrCodeSvg() !!}
                    </div>
                    <x-inputs.button @click="open = false" type="button">Close</x-inputs.button>
                </div>
            </div>
            @method('delete')
            <x-inputs.button type="submit">Disable</x-inputs.button>
        @else
            <p class="text-base font-light leading-normal mt-0 mb-1">2FA is currently disabled</p>
            <x-inputs.button type="submit">Enable</x-inputs.button>
        @endif
    </form>
@endsection