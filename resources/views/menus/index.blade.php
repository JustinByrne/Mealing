@extends('layouts.app')

@section('content')
<div class="flex justify-between py-3">
    <a href="{{ route('menus.index', ['week_start' => $links['prev']]) }}" class="w-full lg:w-auto rounded shadow-md py-1 px-2 bg-gray-400 text-white hover:bg-gray-300 text-xs">
        Prev. Week
    </a>
    <a href="{{ route('menus.index', ['week_start' => $links['next']]) }}" class="w-full lg:w-auto rounded shadow-md py-1 px-2 bg-green-600 text-white hover:bg-green-500 text-xs">
        Next Week
    </a>
</div>
    @if (is_null($current))
        <div class="flex justify-center items-center bg-white dark:bg-gray-700 rounded w-full py-52">
            <div class="flex flex-col dark:text-gray-200 text-center space-y-2">
                <i class="fas fa-hamburger fa-4x"></i>
                <p class="mb-5 dark:text-gray-200">
                    You don't have a menu for this week
                </p>
                <a href="{{ route('menus.create') }}" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-600 text-white hover:bg-green-500">
                    Create Menu
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 gap-2">
            @foreach ($weekDays as $day => $date)
                @php
                    $meal = $current->meals()->with('media', 'ratings')->where('date', $date)->first();    
                @endphp
                <a href="{{ route('meals.show', $meal) }}" class="rounded shadow bg-white dark:bg-gray-700">
                    <div class="text-center font-bold dark:text-gray-200 py-3">
                        {{ $day }}
                    </div>
                    <div>
                        @if( $meal->getMedia()->count() > 0)
                            <img src="{{ $meal->getFirstMediaUrl() }}" class="w-full max-h-48 object-cover">
                        @else
                            <img src="https://via.placeholder.com/640x360.png?text=No+Image" class="w-full h-48 object-cover">
                        @endif
                    </div>
                    <div class="p-2">
                        <p class="mb-1 dark:text-gray-200">
                            {{ $meal->name }}
                        </p>
                        <p class="text-sm text-yellow-400 mb-3" title="{{ $meal->avg_rating > 0 ? $meal->avg_rating : '0' }}">
                            @for ($x = 0; $x < 5; $x++)
                                @if (floor($meal->avg_rating)-$x >= 1)
                                    <i class="fas fa-star"></i>
                                @elseif ($meal->avg_rating-$x > 0)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </p>
                        <p class="mb-3 dark:text-gray-200">
                            Serves: {{ $meal->servings }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="w-full rounded-md shadow-md bg-white dark:bg-gray-700 mt-5">
            <div class="w-full p-4 border-b border-gray-200">
                <p class="font-bold dark:text-gray-200">
                    Shopping List
                </p>
            </div>
            <div class=" p-3">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 gap-2">
                    @foreach ($current->meals as $meal)
                        <div>
                            @foreach ($meal->ingredients as $ingredient)
                                <p class="dark:text-gray-200">
                                    {{ $ingredient->pivot->quantity }} x {{ $ingredient->name }}
                                </p>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection