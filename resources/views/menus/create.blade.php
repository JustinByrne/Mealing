@extends('layouts.app')

@section('content')
<form action="{{ route('menus.store') }}" method="POST">
    @csrf
    <input type="text" name="wc" value="{{ $date }}">
    @livewire('menus.create')
    <button type="submit">
        save
    </button>
</form>
@endsection