@extends('layouts.app')

@section('title', $meal->name)

@include('meals.sidebar')

@section('content')
    <div class="font-sans">
        <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">{{ $meal->name }}</h1>
        <hr class="border-b border-gray-400">
    </div>

    <div class="grid grid-cols-3 gap-4 pt-6">
        <div class="">
            <h2 class="font-sans break-normal text-orange-600 text-lg pb-2">
                Ingredients
            </h2>
            @foreach ($meal->ingredients as $ingredient)
                <p class="text-base font-light leading-normal mt-0 mb-1 ml-3">
                    {{ $ingredient->pivot->quantity }} {{ $ingredient->name }}
                </p>
            @endforeach
        </div>
        <div class="col-span-2">
            <h2 class="font-sans break-normal text-orange-600 text-lg pb-3">
                Method
            </h2>
            {!! $meal->instruction !!}
        </div>
    </div>
@endsection