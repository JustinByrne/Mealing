@extends('layouts.app')

@if (request()->routeIs('ingredients.all'))
    @section('title', 'All Ingredients')
@else
    @section('title', 'My Ingredients')
@endif

@include('ingredients.sidebar')

@section('content')
    <div class="font-sans">
        <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">Ingredients</h1>
        <hr class="border-b border-gray-400">
    </div>

    <div class="flex flex-col mt-5">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <x-th>Ingredient</x-th>
                                <x-th>Number of Meals</x-th>
                                @if (request()->routeIs('ingredients.all')) <x-th>Owner</x-th> @endif
                                <x-th></x-th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($ingredients as $ingredient)
                                <tr>
                                    <x-td>{{ $ingredient->name }}</x-td>
                                    <x-td>{{ $ingredient->meals()->count() }}</x-td>
                                    @if (request()->routeIs('ingredients.all')) <x-td>{{ $ingredient->user->name }}</x-td> @endif
                                    <x-td class="text-right font-medium">
                                        @if ($ingredient->user->id == Auth::Id())
                                            <div class="inline-flex">
                                                <a href="{{ $ingredient->path() }}/edit" class="px-2 py-1 text-blueGray-600 rounded-full  hover:text-white hover:bg-green-600">Edit</a>
                                                <form action="{{ $ingredient->path() }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="px-2 py-1 text-blueGray-600 rounded-full font-medium hover:text-white hover:bg-red-600">Delete</button>
                                                </form>
                                            </div>
                                        @endif
                                    </x-td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection