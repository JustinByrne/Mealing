@extends('user.profile.layout')

@section('title', 'Account Settings')

@section('user.content')
<div class="bg-white rounded-md dark:bg-gray-700">
    <div class="w-full p-4 border-b border-gray-200 ">
        <p class="font-bold dark:text-gray-200">
            User Account Settings
        </p>
    </div>
    <div class="p-4">
        <section>
            <p class="font-bold dark:text-gray-200 mb-3">
                Profile
            </p>
            @if (session('profileStatus'))
                <div class="bg-green-400 bg-opacity-20 text-green-700 border-l-4 border-green-400 py-3 px-4 dark:bg-opacity-40 dark:text-green-400">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('profileStatus') }}
                </div>
            @endif
            <form action="{{ route('profile.settings.account') }}" method="POST" class="space-y-2">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 lg:grid-cols-6">
                    <label for="name" class="dark:text-gray-200 self-center">
                        Name
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-6">
                    <label for="email" class="dark:text-gray-200 self-center">
                        Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                </div>
                <div>
                    <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
                        Save
                    </button>
                </div>
            </form>
        </section>
        <br><hr class="py-2">
        <section>
            <p class="font-bold dark:text-gray-200 mb-3">
                Change Password
            </p>
            @if (session('passwordStatus'))
                <div class="bg-green-400 bg-opacity-20 text-green-700 border-l-4 border-green-400 py-3 px-4 dark:bg-opacity-40 dark:text-green-400">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('passwordStatus') }}
                </div>
            @endif
            @error('current')
                <div class="bg-red-400 bg-opacity-20 text-red-700 border-l-4 border-red-400 py-3 px-4 dark:bg-opacity-40 dark:text-red-300">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                </div>
            @enderror
            @error('password')
                <div class="bg-red-400 bg-opacity-20 text-red-700 border-l-4 border-red-400 py-3 px-4 dark:bg-opacity-40 dark:text-red-300">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                </div>
            @enderror
            <form action="{{ route('profile.settings.password') }}" method="POST" class="space-y-2">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-6">
                    <label for="current" class="dark:text-gray-200 self-center">
                        Current Password
                    </label>
                    <input type="password" name="current" id="current" required class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-6">
                    <label for="password" class="dark:text-gray-200 self-center">
                        New Password
                    </label>
                    <input type="password" name="password" id="password" required class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-6">
                    <label for="password_confirmation" class="dark:text-gray-200 self-center">
                        Confirm Password
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                </div>
                <div>
                    <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
                        Change
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection