@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="w-full h-screen/4">
        @if ($meal->getMedia()->count() > 0)
            <img src="{{ $meal->getFirstMediaUrl() }}" class="w-full h-full object-cover rounded-xl">
        @else
            <img src="https://via.placeholder.com/640x360.png?text=No+Image" class="w-full h-full object-cover rounded-xl">
        @endif
    </div>
    <div class="w-full p-4 bg-white rounded-md shadow dark:bg-gray-700 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="">
                <h4 class="text-2xl font-bold mb-5 dark:text-gray-200 text-green-700">
                    Ingredients
                </h4>
                <p class="mb-5 dark:text-gray-200">
                    <ul>
                        @foreach ($meal->ingredients as $ingredient)
                            <li class="dark:text-gray-200"">
                                {{ $ingredient->pivot->quantity }} {{ $ingredient->name }}
                            </li>
                        @endforeach
                    </ul>
                </p>
            </div>
            <div class="md:col-span-2">
                <div class="flex justify-between">
                    <div>
                        <h4 class="text-2xl font-bold mb-5 dark:text-gray-200 text-green-700">
                            Method
                        </h4>
                    </div>
                    <div>
                        @can('meal_update')
                            @if ($meal->user->id == Auth::id())
                                <a href="{{ route('meals.edit', $meal) }}" class="w-full lg:w-auto rounded shadow-md py-1 px-2 bg-green-600 text-white hover:bg-green-500 text-xs">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif
                        @endcan
                    </div>
                </div>
                <article class="max-w-full prose dark:text-gray-200"">
                    {!! $meal->instruction !!}
                </article>
            </div>
        </div>
        <div>
            <h5 class="text-xl font-bold mb-5 dark:text-gray-200 text-green-700">
                Comments
            </h5>
            @livewire('comments', ['meal' => $meal])
        </div>
    </div>
</div>
@endsection