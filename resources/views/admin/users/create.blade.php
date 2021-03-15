@extends('layouts.app')

@section('title', 'Create New User - Admin')

@include('admin.sidebar')

@section('content')
<div class="font-sans">
    <div class="flex justify-between">
        <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">
            Create New User
        </h1>
    </div>
    <hr class="border-b border-gray-400">
</div>

<div class="pt-5">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                <label for="name" class="font-light text-xs md:pt-2 md:text-base">
                    Name
                </label>
                <div class="w-full md:col-span-4">
                    <x-inputs.text type="text" class="font-light text-sm" name="name" id="name" value="{{ old('name') }}" :error="$errors->has('name')" required="required" />
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
                    <x-inputs.text type="email" class="font-light text-sm" name="email" id="email" value="{{ old('email') }}" :error="$errors->has('email')" required="required" />
                    @error('email')
                        <p class="text-red-500 italic text-xs font-light">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                <label for="password" class="font-light text-xs md:pt-2 md:text-base">
                    Password
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
                    Confirm Password
                </label>
                <div class="w-full md:col-span-4">
                    <x-inputs.text type="password" class="font-light text-sm" name="password_confirmation" id="password_confirmation" :error="$errors->has('password_confirmation')" required="required" />
                    @error('password_confirmation')
                        <p class="text-red-500 italic text-xs font-light">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div>
                <x-inputs.button type="submit">Add User</x-inputs.button>
            </div>
        </div>
    </form>
</div>
@endsection