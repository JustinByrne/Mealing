@extends('layouts.app')

@section('title', 'Permissions - Admin')

@include('admin.sidebar')

@section('content')
    @livewire('permissions.index')
@endsection