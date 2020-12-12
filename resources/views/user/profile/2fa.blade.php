@extends('layouts.app')

@section('title', '2FA')

@section('content')
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

    <form action="/user/two-factor-authentication" method="POST">
        @csrf
        @if (is_null(\Auth::user()->two_factor_secret))
            <p class="text-base font-light leading-normal mt-0 mb-1">2FA is currently disabled</p>
            <x-button type="submit">Enable</x-button>
        @else
            @method('delete')
            <div class="pb-3">
                {!! \Auth::user()->twoFactorQrCodeSvg() !!}
            </div>
            <x-button type="submit">Disable</x-button>
        @endif
    </form>
@endsection