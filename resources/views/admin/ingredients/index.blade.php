@extends('layouts.app')

@section('title', 'Ingredients')

@include('admin.sidebar')

@section('content')
    @livewire('ingredients.index')
@endsection