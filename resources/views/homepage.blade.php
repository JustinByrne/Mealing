@extends('layouts.app')

@section('content')
<p class="font-bold mb-5 dark:text-gray-200">
    Top rated recipes
</p>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-5">
    @foreach ($topRecipes as $recipe)
        <a href="{{ route('recipes.show', $recipe) }}">
            <div class="w-full h-full rounded-md shadow-md bg-white dark:bg-gray-700">
                <div>
                    @if ($recipe->getMedia()->count() > 0)
                        <img src="{{ $recipe->getFirstMediaUrl('default', 'thumb') }}" class="w-full h-32 object-cover rounded-t-md" alt="{{ $recipe->name }}">
                    @else
                        <img src="https://via.placeholder.com/640x360.png?text=No+Image" class="w-full h-32 object-cover rounded-t-md" alt="No image available">
                    @endif
                </div>
                <div class="p-4 rounded-b-md dark:text-gray-200">
                    <p class="mb-2">
                        {{ $recipe->name }}
                    </p>
                    <p class="text-sm text-yellow-400" title="{{ $recipe->avg_rating > 0 ? $recipe->avg_rating : '0' }}">
                        @for ($x = 0; $x < 5; $x++)
                            @if (floor($recipe->avg_rating)-$x >= 1)
                                <i class="fas fa-star"></i>
                            @elseif ($recipe->avg_rating-$x > 0)
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