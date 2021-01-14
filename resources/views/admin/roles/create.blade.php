@extends('layouts.app')

@section('title', 'Create New Role - Admin')

@include('admin.sidebar')

@section('content')
    <div>
        <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">
            Create New Role
        </h1>
        <hr class="border-b border-gray-400">
    </div>

    <div class="pt-5">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                    <label for="title" class="font-light text-xs md:pt-2 md:text-base">
                        Title
                    </label>
                    <div class="w-full md:col-span-4">
                        <x-inputs.text type="text" class="font-light text-sm" name="title" id="title" value="{{ old('title') }}" :error="$errors->has('title')" required="required" />
                        @error('title')
                            <p class="text-red-500 italic text-xs font-light">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="md:space-y-2">
                    <label for="description" class="font-light text-xs md:pt-2 md:text-base">
                        Description
                    </label>
                    @error('description')
                        <p class="text-red-500 italic text-xs font-light">
                            {{ $message }}
                        </p>
                    @enderror
                    <x-inputs.textarea name="description" id="description" required="required" class="h-48">{{ old('description') }}</x-inputs.textarea>
                </div>

                <div>
                    <x-inputs.button type="submit">Add Role</x-inputs.button>
                </div>
            </div>
        </form>
    </div>
@endsection