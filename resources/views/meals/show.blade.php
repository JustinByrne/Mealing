@extends('layouts.app')

@section('title', $meal->name)

@include('meals.sidebar')

@section('content')
    
    @if( $meal->getMedia()->count() > 0)
        <div class="w-full">
            <img src="{{ $meal->getFirstMediaUrl() }}" class="w-full object-cover h-52 rounded">
        </div>
    @endif

    <div class="font-sans">
        <div class="flex justify-between">
            <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">
                {{ $meal->name }} <x-rating :rating="$meal->avg_rating" class="text-xs"></x-rating>
            </h1>
            @if ($meal->user->id == Auth::Id())
                <div class="pt-6 inline-flex">
                    <a href="{{ $meal->path() }}/edit" class="px-2 py-1 text-blueGray-600 font-medium hover:text-lime-600">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <form action="{{ $meal->path() }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 text-blueGray-600 font-medium hover:text-red-700">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            @endif
        </div>
        <hr class="border-b border-gray-400">
    </div>

    <div class="text-xl pt-2">
        @foreach ($allAllergens as $allergen)
            <x-allergen icon="{{ $allergen->icon }}" name="{{ $allergen->name }}" level="{{ array_key_exists($allergen->id, $allergens) ? $allergens[$allergen->id] : '' }}" />
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 pt-2">
        <div class="grid-cols-full lg:grid-cols-1">
            <h2 class="font-sans break-normal text-orange-600 text-lg pb-2">
                Ingredients
            </h2>
            @foreach ($meal->ingredients as $ingredient)
                <p class="text-base font-light leading-normal mt-0 mb-1 ml-3">
                    {{ $ingredient->pivot->quantity }} {{ $ingredient->name }}
                </p>
            @endforeach
        </div>
        <div class="grid-cols-full lg:col-span-2">
            <h2 class="font-sans break-normal text-orange-600 text-lg pb-3">
                Method
            </h2>
            <div class="text-base font-light leading-relaxed mt-0 space-y-3 text-lightGray-800">
                {!! nl2br($meal->instruction) !!}
            </div>
        </div>
    </div>

    <h2 class="font-sans break-normal text-orange-600 text-lg pb-2 mt-12">
        Comments
    </h2>

    @livewire('comments', ['meal' => $meal])
@endsection