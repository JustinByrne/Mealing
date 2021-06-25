@extends('admin.layout')

@section('admin.content')
    <div class="grid grid-cols-1 lg:grid-cols-4 p-4 gap-4">
        <div class="shadow-lg rounded-lg p-4 bg-gradient-to-br from-green-400 to-blue-500 h-32">
            <p class="font-black text-white text-xl">
                {{ $users }}
            </p>
            <p class="font-black text-white text-xl">
                Users
            </p>
        </div>
        <div class="shadow-lg rounded-lg p-4 bg-gradient-to-br from-green-400 to-blue-500 h-32">
            <p class="font-black text-white text-xl">
                {{ $meals }}
            </p>
            <p class="font-black text-white text-xl">
                Meals
            </p>
        </div>
        <div class="shadow-lg rounded-lg p-4 bg-gradient-to-br from-green-400 to-blue-500 h-32">
            <p class="font-black text-white text-xl">
                {{ $ingredients }}
            </p>
            <p class="font-black text-white text-xl">
                Ingredients
            </p>
        </div>
        {{-- <div class="shadow-lg rounded-lg p-4 bg-gradient-to-br from-green-400 to-blue-500 h-32">
            <p class="font-black text-white text-xl">
                
            </p>
            <p class="font-black text-white text-xl">
                
            </p>
        </div> --}}
    </div>
@endsection