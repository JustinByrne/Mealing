@extends('layouts.app')

@section('content')
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
            <div class="rounded shadow bg-white dark:bg-gray-700">
                <div class="text-center font-bold dark:text-gray-200 py-1">
                    {{ $day }}
                </div>
                <div>
                    @if( $current->meals()->with('media')->where('date', $date)->first()->getMedia()->count() > 0)
                        <img src="{{ $current->meals()->with('media')->where('date', $date)->first()->getFirstMediaUrl() }}" class="w-full max-h-32 object-cover">
                    @else
                        <img src="https://via.placeholder.com/640x360.png?text=No+Image" class="w-full h-32 object-cover">
                    @endif
                </div>
                <div class="p-2">
                    <p class="mb-5 dark:text-gray-200">
                        {{ $current->meals()->where('date', $date)->first()->name }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    @endif
@endsection