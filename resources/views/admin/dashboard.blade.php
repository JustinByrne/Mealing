@extends('layouts.app')

@section('title', 'Admin')

@include('admin.sidebar')

@section('content')
<div class="flex flex-wrap">
    <div class="w-1/2 lg:w-1/4 h-36 px-4 mb-4 lg:mb-0">
        <div class="w-full h-full shadow-lg rounded p-2 bg-gradient-to-br from-yellow-400 via-red-500 to-pink-500">
            <div>
                <p class="text-8xl text-white text-opacity-80">
                    {{ $users }}
                </p>
                <p class="text-right text-white text-xl pr-4">
                    Users
                </p>
            </div>
        </div>
    </div>
    <div class="w-1/2 lg:w-1/4 h-36 px-4 mb-4 lg:mb-0">
        <div class="w-full h-full shadow-lg rounded p-2 bg-gradient-to-br from-yellow-400 via-red-500 to-pink-500">
            <div>
                <p class="text-8xl text-white text-opacity-80">
                    {{ $meals }}
                </p>
                <p class="text-right text-white text-xl pr-4">
                    Meals
                </p>
            </div>
        </div>
    </div>
    <div class="w-1/2 lg:w-1/4 h-36 px-4 mb-4 lg:mb-0">
        <div class="w-full h-full shadow-lg rounded p-2 bg-gradient-to-br from-yellow-400 via-red-500 to-pink-500">
            <div>
                <p class="text-8xl text-white text-opacity-80">
                    {{ $ingredients }}
                </p>
                <p class="text-right text-white text-xl pr-4">
                    ingredients
                </p>
            </div>
        </div>
    </div>
</div>
@endsection