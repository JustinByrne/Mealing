@extends('layouts.app')

@if (request()->routeIs('meals.all'))
    @section('title', 'All Meals')
@else
    @section('title', 'My Meals')
@endif

@include('meals.sidebar')

@section('content')
    @if (\Request::routeIs('meals.all'))
        @livewire('meals', ['allmeals' => True])
    @else
        @livewire('meals')
    @endif
@endsection