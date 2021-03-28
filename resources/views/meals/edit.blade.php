@extends('layouts.app')

@section('title', 'Edit ' . $meal->name)

@include('meals.sidebar')

@section('content')
    <div>
        <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">
            Edit {{ $meal->name }}
        </h1>
        <hr class="border-b border-gray-400">
    </div>

    <div class="pt-5">
        <form action="{{ route('meals.update', $meal) }}" method="POST">
            @csrf
            @method('patch')
            <div class="space-y-4">
                <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                    <label for="name" class="font-light text-xs md:pt-2 md:text-base">
                        Name
                    </label>
                    <div class="w-full md:col-span-4">
                        <x-inputs.text type="text" class="font-light text-sm" name="name" id="name" value="{{ Request::old('name', $meal->name) }}" :error="$errors->has('name')" required="required" />
                        @error('name')
                            <p class="text-red-500 italic text-xs font-light">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                    <label for="servings" class="font-light text-xs md:pt-2 md:text-base">
                        # of Servings
                    </label>
                    <div class="w-full md:col-span-4">
                        <x-inputs.text type="number" class="font-light text-sm" name="servings" id="servings" value="{{ Request::old('servings', $meal->servings) }}" :error="$errors->has('servings')" required="required" />
                        @error('servings')
                            <p class="text-red-500 italic text-xs font-light">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="items-top md:grid md:grid-cols-9 md:space-x-6">
                    <label for="timing" class="font-light text-xs md:pt-2 md:text-base">
                        Time in Minutes
                    </label>
                    <div class="w-full md:col-span-4">
                        <x-inputs.text type="number" class="font-light text-sm" name="timing" id="timing" value="{{ Request::old('timing', $meal->timing) }}" :error="$errors->has('timing')" required="required" />
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
                        @if( $meal->getMedia()->count() > 0)
                            <div class="flex items-center space-x-2">
                                <img src="{{ $meal->getFirstMediaUrl() }}" class="h-16 rounded">
                                <span class="text-red-500">
                                    <i class="fas fa-times"></i>
                                </span>
                            </div>
                        @else
                            <input type="file" name="image">
                        @endif
                    </div>
                </div>

                <div class="space-y-2 md:flex md:space-y-0 md:space-x-3">
                    <div>
                        <input type="checkbox" name="adult" id="adult" value="1" {{ $meal->adults ? 'checked' : '' }}>
                        <label for="adult" class="font-light text-xs md:pt-2 md:text-base">
                            Suitable for Adults
                        </label>
                    </div>
                    <div>
                        <input type="checkbox" name="kids" id="kids" value="1" {{ $meal->kids ? 'checked' : '' }}>
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
                        @foreach ($allAllergens as $allergen)
                            <div class="inline cursor-pointer" x-data="{ level: {{ array_key_exists($allergen->id, $allergens) ? "'" . $allergens[$allergen->id] . "'" : "'no'" }} }">
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
                    <label for="instruction" class="font-light text-xs md:pt-2 md:text-base">
                        Ingredients
                    </label>
                    @livewire('meals.create', ['meal' => $meal])
                </div>

                <div class="md:space-y-2">
                    <label for="instruction" class="font-light text-xs md:pt-2 md:text-base">
                        Instructions
                    </label>
                    <x-inputs.textarea name="instruction" id="instruction" :error="$errors->has('instruction')" required="required" class="h-96">{{ $meal->instruction }}</x-inputs.textarea>
                </div>

                <div>
                    <x-inputs.button type="submit">Update Meal</x-inputs.button>
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