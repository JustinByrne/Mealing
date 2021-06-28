@extends('layouts.app')

@section('content')
@if ($recipes->count() > 0)
    <div class="flex flex-col lg:flex-row lg:space-x-6">
        <div class="w-full">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-5">
                @foreach ($recipes as $recipe)
                    <a href="{{ route('recipes.show', $recipe) }}">
                        <div class="w-full h-full rounded-md shadow-md bg-white dark:bg-gray-700">
                            <div>
                                @if ($recipe->getMedia()->count() > 0)
                                    <img src="{{ $recipe->getFirstMediaUrl('default', 'thumb') }}" class="w-full h-32 object-cover rounded-t-md" alt="{{ $recipe->name }}">
                                @else
                                    <img src="https://via.placeholder.com/640x360.png?text=No+Image" class="w-full max-h-32 object-cover rounded-t-md" alt="No image available">
                                @endif
                            </div>
                            <div class="p-4 rounded-b-md dark:text-gray-200 space-y-2">
                                <p>
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
                                <p>
                                    Serves: {{ $recipe->servings }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            {{ $recipes->links() }}
        </div>
    </div>
@else
<div class="flex justify-center items-center bg-white dark:bg-gray-700 rounded w-full py-52">
    <div class="flex flex-col dark:text-gray-200 text-center space-y-2">
        <i class="fas fa-hamburger fa-4x"></i>
        <p class="mb-5 dark:text-gray-200">
            You don't currently like any recipes. Check some of them out, they're some pretty good ones.
        </p>
    </div>
</div>
@endif
@endsection