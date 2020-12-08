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
                    @livewire('ingredients', ['ingredients' => $ingredients])
                </div>
            </div>
        </div>
    </div>
@endsection