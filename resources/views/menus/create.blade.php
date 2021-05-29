@extends('layouts.app')

@section('content')
<form action="{{ route('menus.store') }}" method="POST">
    @csrf
    <input type="text" name="wc" value="{{ $date }}">
    <input type="text" name="monday">
    <input type="text" name="tuesday">
    <input type="text" name="wednesday">
    <input type="text" name="thursday">
    <input type="text" name="friday">
    <input type="text" name="saturday">
    <input type="text" name="sunday">
    <button type="submit">
        save
    </button>
</form>
@endsection