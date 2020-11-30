@extends('layouts.app')

@section('title', $ingredient->name)

@include('ingredients.sidebar')

@section('content')
    <div class="font-sans">
        <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">{{ $ingredient->name }}</h1>
        <hr class="border-b border-gray-400">
    </div>

    @if ($ingredient->meals()->count() == 0)
        <p class="py-5">
            There are currently no meals using this ingredient
        </p>
    @else
        <div class="flex flex-col mt-5">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <x-th>Meal</x-th>
                                    <x-th>Rating</x-th>
                                    <x-th></x-th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($ingredient->meals as $meal)
                                    <tr>
                                        <x-td>{{ $meal->name }}</x-td>
                                        <x-td></x-td>
                                        <x-td class="text-right font-medium">
                                            <div class="inline-flex">
                                                <a href="{{ $meal->path() }}" class="px-2 py-1 text-blueGray-600 font-medium hover:text-orange-500">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if ($meal->user->id == Auth::Id())
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
                                                @endif
                                            </div>
                                        </x-td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection