@extends('layouts.app')

@section('title', 'Create New Meal')

@include('meals.sidebar')

@section('content')
    <div>
        <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">
            Create New Meal
        </h1>
        <hr class="border-b border-gray-400">
    </div>

    <div class="pt-5">
        <form action="{{ route('meals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div class="items-start md:grid md:grid-cols-9 md:space-x-6">
                    <label for="name" class="font-light text-xs md:pt-2 md:text-base">
                        Name
                    </label>
                    <div class="w-full md:col-span-4">
                        <x-inputs.text type="text" class="font-light text-sm" name="name" id="name" value="{{ Request::old('name') }}" :error="$errors->has('name')" required="required" />
                        @error('name')
                            <p class="text-red-500 italic text-xs font-light">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="items-start md:grid md:grid-cols-9 md:space-x-6">
                    <label for="servings" class="font-light text-xs md:pt-2 md:text-base">
                        # of Servings
                    </label>
                    <div class="w-full md:col-span-4">
                        <x-inputs.text type="number" class="font-light text-sm" name="servings" id="servings" value="{{ Request::old('servings') }}" :error="$errors->has('servings')" required="required" />
                        @error('servings')
                            <p class="text-red-500 italic text-xs font-light">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="items-start md:grid md:grid-cols-9 md:space-x-6">
                    <label for="timing" class="font-light text-xs md:pt-2 md:text-base">
                        Time in Minutes
                    </label>
                    <div class="w-full md:col-span-4">
                        <x-inputs.text type="number" class="font-light text-sm" name="timing" id="timing" value="{{ Request::old('timing') }}" :error="$errors->has('timing')" required="required" />
                        @error('timing')
                            <p class="text-red-500 italic text-xs font-light">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="items-start md:grid md:grid-cols-9 md:space-x-6">
                    <label for="image" class="font-light text-xs md:pt-2 md:text-base">
                        Image
                    </label>
                    <div class="w-full md:col-span-4">
                        <input type="file" name="image">
                    </div>
                </div>

                <div class="space-y-2 md:flex md:space-y-0 md:space-x-3">
                    <div>
                        <input type="checkbox" name="adult" id="adult" value="1">
                        <label for="adult" class="font-light text-xs md:pt-2 md:text-base">
                            Suitable for Adults
                        </label>
                    </div>
                    <div>
                        <input type="checkbox" name="kids" id="kids" value="1">
                        <label for="kids" class="font-light text-xs md:pt-2 md:text-base">
                            Suitable for Children
                        </label>
                    </div>
                </div>

                <div class="items-start md:grid md:grid-cols-9 md:space-x-6">
                    <label class="font-light text-xs md:pt-2 md:text-base">
                        Allergens
                    </label>
                    <div class="w-full md:col-span-4 md:pt-1 text-2xl">
                        @foreach ($allergens as $allergen)
                            <div class="inline cursor-pointer" x-data="{ level: 'no' }">
                                <x-allergen
                                    icon="{{ $allergen->icon }}"
                                    name="{{ $allergen->name }}"
                                    x-on:click="level = changeLevel(level)"
                                    x-bind:class="{
                                        'allergen-level-no': level == 'no',
                                        'allergen-level-may': level == 'may',
                                        'allergen-level-yes': level == 'yes',
                                    }"
                                />
                                <input type="hidden" name="allergens[{{ $allergen->id }}]" x-model="level">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="md:space-y-2">
                    <label class="font-light text-xs md:pt-2 md:text-base">
                        Ingredients
                    </label>
                    @error('ingredients')
                            <p class="text-red-500 italic text-xs font-light">
                                {{ $message }}
                            </p>
                        @enderror
                    @livewire('meals.create')
                </div>

                <div class="md:space-y-2">
                    <label for="instruction" class="font-light text-xs md:pt-2 md:text-base">
                        Instructions
                    </label>
                    <x-inputs.textarea name="instruction" id="instruction" :error="$errors->has('instruction')" required="required" class="h-96" />
                </div>

                <div>
                    <x-inputs.button type="submit">Add Meal</x-inputs.button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function changeLevel($current)  {
            switch($current) {
                case 'no':
                    return 'may';
                    break;
                case 'may':
                    return 'yes';
                    break;
                case 'yes':
                    return 'no';
                    break;
            }
        }
    </script>
@endsection