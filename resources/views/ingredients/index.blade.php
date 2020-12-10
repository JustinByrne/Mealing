@extends('layouts.app')

@if (request()->routeIs('ingredients.all'))
    @section('title', 'All Ingredients')
@else
    @section('title', 'My Ingredients')
@endif

@include('ingredients.sidebar')

@section('content')
    @if (\Request::routeIs('ingredients.all'))
        @livewire('ingredients', ['allIngredients' => True])
    @else
        @livewire('ingredients')
    @endif
@endsection