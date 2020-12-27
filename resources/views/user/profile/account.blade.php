@extends('layouts.app')

@section('title', 'My Settings')

@include('user.profile.sidebar')

@section('content')
    <h1 class="font-sans break-normal text-gray-900 pt-6 pb-4 text-xl">Account Settings</h1>
    <hr class="border-b border-gray-400 mb-3">

    <form method="POST">
        @csrf
        @method('PATCH')
        <div class="space-y-4">
            <div class="items-top md:flex md:space-x-6">
                <label for="name" class="font-light text-xs md:pt-2 md:text-base">
                    Name
                </label>
                <div class="w-full md:max-w-md">
                    <x-inputs.text type="text" class="font-light text-sm" name="name" id="name" value="{{ \Auth::User()->name }}" :error="$errors->has('name')" required="required" />
                    @error('name')
                        <p class="text-red-500 italic text-xs font-light">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="items-top md:flex md:space-x-6">
                <label for="email" class="font-light text-xs md:pt-2 md:text-base">
                    Email
                </label>
                <div class="w-full md:max-w-md">
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
@endsection