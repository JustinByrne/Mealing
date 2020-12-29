@extends('layouts.app')

@section('title', 'My Settings')

@include('user.profile.sidebar')

@section('content')
    <h1 class="font-sans break-normal text-gray-900 pt-6 pb-4 text-xl">Account Settings</h1>
    <hr class="border-b border-gray-400 mb-3">

    <div class="space-y-10">
        <div>
            <h2 class="font-bold pb-2">Profile</h2>
            @if (session('profileStatus'))
                <x-alert type="info">
                    {{ session('profileStatus') }}
                </x-alert>
            @endif
            <form method="POST">
                @csrf
                @method('PATCH')
                <div class="space-y-4">
                    <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                        <label for="name" class="font-light text-xs md:pt-2 md:text-base">
                            Name
                        </label>
                        <div class="w-full md:col-span-4">
                            <x-inputs.text type="text" class="font-light text-sm" name="name" id="name" value="{{ \Auth::User()->name }}" :error="$errors->has('name')" required="required" />
                            @error('name')
                                <p class="text-red-500 italic text-xs font-light">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                        <label for="email" class="font-light text-xs md:pt-2 md:text-base">
                            Email
                        </label>
                        <div class="w-full md:col-span-4">
                            <x-inputs.text type="email" class="font-light text-sm" name="email" id="email" value="{{ \Auth::User()->email }}" :error="$errors->has('name')" required="required" />
                            @error('name')
                                <p class="text-red-500 italic text-xs font-light">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <x-inputs.button type="submit">
                            Save
                        </x-inputs.button>
                    </div>
                </div>
            </form>
        </div>

        <div>
            <h2 class="font-bold pb-2">Change Password</h2>
            @if (session('passwordStatus'))
                <x-alert type="info">
                    {{ session('passwordStatus') }}
                </x-alert>
            @endif
            <form action="{{ route('profile.settings.password') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                        <label for="current" class="font-light text-xs md:pt-2 md:text-base">
                            Current Password
                        </label>
                        <div class="w-full md:col-span-4">
                            <x-inputs.text type="password" class="font-light text-sm" name="current" id="current" :error="$errors->has('current')" required="required" />
                            @error('current')
                                <p class="text-red-500 italic text-xs font-light">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                        <label for="password" class="font-light text-xs md:pt-2 md:text-base">
                            New Password
                        </label>
                        <div class="w-full md:col-span-4">
                            <x-inputs.text type="password" class="font-light text-sm" name="password" id="password" :error="$errors->has('password')" required="required" />
                            @error('password')
                                <p class="text-red-500 italic text-xs font-light">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                        <label for="password_confirmation" class="font-light text-xs md:pt-2 md:text-base">
                            Confirm
                        </label>
                        <div class="w-full md:col-span-4">
                            <x-inputs.text type="password" class="font-light text-sm" name="password_confirmation" id="password_confirmation" :error="$errors->has('password_confirmation')" required="required" />
                        </div>
                    </div>
                    <div>
                        <x-inputs.button type="submit">
                            Change
                        </x-inputs.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection