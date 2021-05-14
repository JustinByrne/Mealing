@extends('layouts.app')

@section('content')
<div class="flex flex-col lg:flex-row lg:space-x-6">
    <div class="w-full lg:w-4/5 order-2 lg:order-1">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-5">
            @foreach ($meals as $meal)
                <div class="w-full rounded-md shadow-md dark:bg-gray-700">
                    <div>
                        @if ( $meal->getMedia('images')->count() > 0)
                            <img src="{{ $meal->getMedia('images')->first()->getUrl() }}" class="w-full max-h-32 object-cover rounded-t-md">
                        @else
                            <img src="https://via.placeholder.com/640x360.png?text=No+Image" class="w-full max-h-32 object-cover rounded-t-md">
                        @endif
                    </div>
                    <div class="bg-white p-4 rounded-b-md dark:bg-gray-700 dark:text-gray-200 space-y-2">
                        <p>
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
                        <p>
                            Serves: {{ $meal->servings }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $meals->links() }}
    </div>
    <div class="w-full lg:w-1/5 order-1 mb-3 lg:mb-0" x-data="{open: false}">
        <div class="w-full rounded-md shadow-md bg-white dark:bg-gray-700">
            <div class="flex justify-between p-4 border-b border-gray-200">
                <p class="font-bold dark:text-gray-200 self-center">
                    Filter
                </p>
                <div class="lg:hidden">
                    <button class="border border-gray-100 px-2 pt-1 rounded-lg dark:text-gray-200" @click="open = !open">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
            <div class="hidden lg:block" :class="{'hidden': !open}">
            </div>
        </div>
    </div>
</div>
@endsection