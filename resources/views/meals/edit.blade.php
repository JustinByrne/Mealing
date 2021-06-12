@extends('layouts.app')

@section('content')
<div class="w-full rounded-md shadow-md bg-white dark:bg-gray-700">
    <div class="w-full p-4 border-b border-gray-200">
        <p class="font-bold dark:text-gray-200">
            Create New Meal
        </p>
    </div>
    <div class="p-3">
        <form action="{{ route('meals.update', $meal) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="space-y-4">
                <div class="items-start md:grid md:grid-cols-9 md:space-x-6">
                    <label for="name" class="dark:text-gray-200 self-center">
                        Name
                    </label>
                    <div class="w-full md:col-span-4">
                        <input type="text" name="name" id="name" value="{{ Request::old('name', $meal->name) }}" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                        @error('name')
                            <p class="text-red-500 italic text-xs font-light">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <div class="items-start md:grid md:grid-cols-9 md:space-x-6">
                    <label for="servings" class="dark:text-gray-200 self-center">
                        # of Servings
                    </label>
                    <div class="w-full md:col-span-4">
                        <input type="text" name="servings" id="servings" value="{{ Request::old('servings', $meal->servings) }}" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                        @error('servings')
                            <p class="text-red-500 italic text-xs font-light">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <div class="items-start md:grid md:grid-cols-9 md:space-x-6">
                    <label for="timing" class="dark:text-gray-200 self-center">
                        Time in Minutes
                    </label>
                    <div class="w-full md:col-span-4">
                        <input type="text" name="timing" id="timing" value="{{ Request::old('timing', $meal->timing) }}" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                        @error('timing')
                            <p class="text-red-500 italic text-xs font-light">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <div class="items-start md:grid md:grid-cols-9 md:space-x-6">
                    <label for="image" class="dark:text-gray-200 self-center">
                        Image
                    </label>
                    <div class="w-full md:col-span-4 grid grid-cols-1 md:grid-cols-12">
                        @if( $meal->getMedia()->count() > 0)
                            <div class="md:col-span-2">
                                <img src="{{ $meal->getFirstMediaUrl() }}" class="h-16 rounded">
                            </div>
                        @endif
                        <div class="md:col-span-10" x-data x-init="
                            FilePond.create($refs.input);
                            FilePond.setOptions({
                                server: {
                                    url: '/upload',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                }
                            });
                        ">
                            <input type="file" name="image" x-ref="input">
                        </div>
                    </div>
                </div>
                <div class="space-y-2 md:flex md:space-y-0 md:space-x-3">
                    <div>
                        <input type="checkbox" name="adult" id="adult" value="1"  {{ $meal->adults ? 'checked' : '' }} class="rounded text-green-600 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200 dark:focus:bg-green-600">
                        <label for="adult" class="dark:text-gray-200 self-center">
                            Suitable for Adults
                        </label>
                    </div>
                    <div>
                        <input type="checkbox" name="kids" id="kids" value="1"  {{ $meal->kids ? 'checked' : '' }} class="rounded text-green-600 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200 dark:focus:bg-green-600">
                        <label for="kids" class="dark:text-gray-200 self-center">
                            Suitable for Children
                        </label>
                    </div>
                </div>
                <div class="items-start md:grid md:grid-cols-9 md:space-x-6">
                    <label class="dark:text-gray-200 self-center">
                        Allergens
                    </label>
                    <div class="w-full md:col-span-4 md:pt-1 text-2xl">
                        @foreach ($allAllergens as $allergen)
                            <div class="inline cursor-pointer" x-data="{ level: {{ array_key_exists($allergen->id, $allergens) ? "'" . $allergens[$allergen->id] . "'" : "'no'" }} }">
                                <span
                                    x-on:click="level = changeLevel(level)"
                                    x-bind:class="{
                                        'allergen-level-no': level == 'no',
                                        'allergen-level-may': level == 'may',
                                        'allergen-level-yes': level == 'yes',
                                    }"
                                >
                                    <i class="{{ $allergen->icon }}" title="{{ $allergen->name }}"></i>
                                </span>
                                <input type="hidden" name="allergens[{{ $allergen->id }}]" x-model="level">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="md:space-y-2">
                    <label class="dark:text-gray-200 self-center">
                        Ingredients
                    </label>
                    @error('ingredients')
                        <p class="text-red-500 italic text-xs font-light">
                            {{ $message }}
                        </p>
                    @enderror
                    @livewire('meals.create', ['meal' => $meal])
                </div>
                <div class="md:space-y-2">
                    <label for="instruction" class="dark:text-gray-200 self-center">
                        Instructions
                    </label>
                    <div>
                        <textarea name="instruction" id="instruction" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full h-64 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">{!! old('instruction', $meal->instruction) !!}</textarea>
                    </div>
                </div>
                <div>
                    <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-600 text-white hover:bg-green-500">
                        Update Meal
                    </button>
                </div>
            </div>
        </form>
    </div>
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
<script>
    ClassicEditor
        .create( document.querySelector( '#instruction' ), {
            toolbar: [ 'heading', '|', 'bold', 'italic', '|',  'undo', 'redo', '|', 'bulletedList', 'numberedList' ],
        } )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection