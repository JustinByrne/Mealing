@extends('admin.layout')

@section('title', $ingredient->name)

@section('admin.content')
<div class="w-full p-4 bg-white border-b border-gray-200 rounded-t-md dark:bg-gray-700">
    <p class="font-bold dark:text-gray-200">
        {{ $ingredient->name }}
    </p>
</div>
<div class="p-4 space-y-4">
    @if ($ingredient->recipes()->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-5">
        @foreach ($ingredient->recipes as $recipe)
            <a href="{{ route('recipes.show', $recipe) }}">
                <div class="w-full h-full rounded-md shadow-md dark:bg-gray-700">
                    <div>
                        @if ($recipe->getMedia()->count() > 0)
                            <img src="{{ $recipe->getFirstMediaUrl('default', 'thumb') }}" class="w-full max-h-32 object-cover rounded-t-md">
                        @else
                            <img src="https://via.placeholder.com/640x360.png?text=No+Image" class="w-full h-32 object-cover rounded-t-md">
                        @endif
                    </div>
                    <div class="bg-white p-4 rounded-b-md dark:bg-gray-700 dark:text-gray-200">
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
    @else
        No Recipes are using this ingredient.
    @endif
</div>
@endsection