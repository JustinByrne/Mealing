@extends('layouts.app')

@section('title', 'Allergens - Admin')

@include('admin.sidebar')

@section('content')
<div class="font-sans">
    <div class="flex justify-between">
        <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">
            Edit Allergen
        </h1>
    </div>
    <hr class="border-b border-gray-400">
</div>

<div class="pt-5">
    <form action="{{ route('admin.allergens.update', [$allergen]) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="space-y-4">
            <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                <label for="name" class="font-light text-xs md:pt-2 md:text-base">
                    Name
                </label>
                <div class="w-full md:col-span-4">
                    <x-inputs.text type="text" class="font-light text-sm" name="name" id="name" value="{{ old('name', $allergen->name) }}" :error="$errors->has('name')" required="required" />
                    @error('name')
                        <p class="text-red-500 italic text-xs font-light">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                <label for="icon" class="font-light text-xs md:pt-2 md:text-base">
                    Icon
                </label>
                <div class="w-full md:col-span-4">
                    <x-inputs.text type="text" class="font-light text-sm" name="icon" id="icon" value="{{ old('icon', $allergen->icon) }}" :error="$errors->has('icon')" required="required" />
                    @error('icon')
                        <p class="text-red-500 italic text-xs font-light">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div>
                <x-inputs.button type="submit">Update</x-inputs.button>
            </div>
        </div>
    </form>
</div>
@endsection