@extends('layouts.app')

@section('title', 'Roles - Admin')

@include('admin.sidebar')

@section('content')
    @livewire('roles.index')
@endsection