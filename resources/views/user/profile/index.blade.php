@extends('layouts.app')

@section('title', 'My Profile')

@include('user.profile.sidebar')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 w-full">
        <div class="col-span-full mb-4 lg:mb-0 lg:col-span-1">
            <img class="rounded-full mx-auto shadow-lg" src="{{ $user->getAvatar(300) }}" alt="{{ $user->getFullName() }}">
        </div>
        <div class="col-span-full lg:col-span-3">
            <h1 class="font-sans break-normal text-gray-900 pt-6 pb-4 text-xl">Profile</h1>
            <p class="text-sm font-light leading-relaxed mt-0 mb-2 text-lightGray-800"><strong>Name:</strong> {{ $user->getFullName() }}</p>
            <p class="text-sm font-light leading-relaxed mt-0 mb-2 text-lightGray-800"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="text-sm font-light leading-relaxed mt-0 mb-2 text-lightGray-800"><strong>Subscripiton:</strong> Free</p>
        </div>
    </div>
@endsection