@extends('auth.layout')

@section('title', 'Verify Email')

@section('content')
<div class="p-3 space-y-3">
    @if (session('status') == 'verification-link-sent')
        <div class="bg-blue-400 bg-opacity-20 text-blue-700 border-l-4 border-blue-400 py-3 px-4 dark:bg-opacity-40 dark:text-blue-300">
            <i class="fas fa-info-circle mr-1"></i> Verification link has been sent.
        </div>
    @endif

    <p class="mb-5 dark:text-gray-200">
        Before proceeding, please check your email for a verification link. If you did not receive the email, use the button below.
    </p>

    <div class="text-center">
        <form action="{{ route('verification.send') }}" method="POST">
            @csrf
            <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
                Request new verification link
            </button>
        </form>
    </div>
</div>
@endsection