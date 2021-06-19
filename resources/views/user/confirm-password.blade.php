@extends('user.profile.layout')

@section('user.content')
<div class="bg-white rounded-md dark:bg-gray-700">
    <div class="w-full p-4 border-b border-gray-200 ">
        <p class="font-bold dark:text-gray-200">
            Confirm Password
        </p>
    </div>
    <div class="p-4">
        @error('password')
            <div class="bg-red-400 bg-opacity-20 text-red-700 border-l-4 border-red-400 py-3 px-4 dark:bg-opacity-40 dark:text-red-300">
                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
            </div>
        @enderror
        <form action="{{ route('password.confirm') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-6">
                <label for="password" class="dark:text-gray-200 self-center">
                    Password
                </label>
                <input type="password" name="password" id="password" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
            </div>
            <div>
                <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
                    Confirm
                </button>
            </div>
        </form>
    </div>
</div>
@endsection