@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<x-auth-card>
    @if (session('status') == 'verification-link-sent')
        <x-alert type="info">
            <p>Verification link has been sent.</p>
        </x-alert>
    @endif

    <p class="text-base font-light leading-normal mt-0 mb-1">
        Before proceeding, please check your email for a verification link. If you did not receive the email, use the button below.
    </p>

    <div class="text-center my-3">
        <form action="{{ route('verification.send') }}" method="POST">
            @csrf
            <x-inputs.button type="submit">
                Request new verification link
            </x-inputs.button>
        </form>
    </div>
</x-auth-card>
@endsection