@extends('admin.layout')

@section('admin.content')
<div class="w-full p-4 bg-white border-b border-gray-200 rounded-t-md dark:bg-gray-700">
    <p class="font-bold dark:text-gray-200">
        Edit User
    </p>
</div>
<form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-4 space-y-4">
    @csrf
    @method('PATCH')
    <div class="grid grid-cols-1 lg:grid-cols-6">
        <label for="name" class="dark:text-gray-200 self-center">
            Name
        </label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
        @error('name')
            <p class="text-red-500 italic text-xs font-light">
                {{ $message }}
            </p>
        @enderror
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-6">
        <label for="email" class="dark:text-gray-200 self-center">
            Email
        </label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
        @error('email')
            <p class="text-red-500 italic text-xs font-light">
                {{ $message }}
            </p>
        @enderror
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-6">
        <label for="password" class="dark:text-gray-200 self-center">
            Password
        </label>
        <input type="password" name="password" id="password" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
        @error('password')
            <p class="text-red-500 italic text-xs font-light">
                {{ $message }}
            </p>
        @enderror
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-6">
        <label for="password_confirmation" class="dark:text-gray-200 self-center">
            Confirm Password
        </label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
    </div>
    <div class="">
        <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-600 text-white hover:bg-green-500">
            Save Changes
        </button>
    </div>
</form>
@endsection