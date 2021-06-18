@extends('layouts.app')

@section('content')
<p class="font-bold mb-5 dark:text-gray-200">
    Top rated meals
</p>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-5">
    @foreach ($topMeals as $meal)
        <a href="{{ route('meals.show', $meal) }}">
            <div class="w-full rounded-md shadow-md dark:bg-gray-700">
                <div>
                    @if ($meal->getMedia()->count() > 0)
                        <img src="{{ $meal->getFirstMediaUrl() }}" class="w-full h-32 object-cover rounded-t-md">
                    @else
                        <img src="https://via.placeholder.com/640x360.png?text=No+Image" class="w-full h-32 object-cover rounded-t-md">
                    @endif
                </div>
                <div class="bg-white p-4 rounded-b-md dark:bg-gray-700 dark:text-gray-200">
                    <p class="mb-2">
                        {{ $meal->name }}
                    </p>
                    <p class="text-sm text-yellow-400" title="{{ $meal->avg_rating > 0 ? $meal->avg_rating : '0' }}">
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
                </div>
            </div>
        </a>
    @endforeach
</div>
@endsection