@extends('layouts.app')

@section('content')
<form action="{{ route('menus.store') }}" method="POST">
    @csrf
    <input type="hidden" name="wc" value="{{ $date }}">
    @livewire('menus.create')
    <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-600 text-white hover:bg-green-500">
        Save Menu
    </button>
</form>
@endsection