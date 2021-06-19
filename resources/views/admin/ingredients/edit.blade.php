@extends('admin.layout')

@section('admin.content')
<div class="w-full p-4 bg-white border-b border-gray-200 rounded-t-md dark:bg-gray-700">
    <p class="font-bold dark:text-gray-200">
        Edit Ingredient - {{ $ingredient->name }}
    </p>
</div>
<form action="{{ route('admin.ingredients.update', $ingredient) }}" method="POST" class="p-4 space-y-4">
    @csrf
    @method('PATCH')
    <div class="grid grid-cols-1 lg:grid-cols-6">
        <label for="name" class="dark:text-gray-200 self-center">
            Name
        </label>
        <input type="text" name="name" id="name" value="{{ old('name', $ingredient->name) }}" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
    </div>
    <div>
        <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
            Save Changes
        </button>
    </div>
</form>
@endsection