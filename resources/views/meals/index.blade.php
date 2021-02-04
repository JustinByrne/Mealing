@extends('layouts.app')

@if (request()->routeIs('meals.all'))
    @section('title', 'All Meals')
@else
    @section('title', 'My Meals')
@endif

@include('meals.sidebar')

@section('content')
    @if (\Request::routeIs('meals.all'))
        @livewire('meals.index', ['allmeals' => True])
    @else
        @livewire('meals.index')
    @endif
@endsection