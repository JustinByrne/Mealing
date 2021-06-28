<div>
    <div class="items-top space-y-4 md:space-y-0 md:grid md:grid-cols-9 md:space-x-6">
        <div>
            <input type="text" placeholder="Amount" wire:model="quantity" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
        </div>
        <div class="w-full relative md:col-span-4">
            <input type="text" placeholder="Search Ingredients..." wire:model.debounce.300ms="query" wire:keydown.escape="resetQuery" wire:keydown.tab="resetQuery" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
            
            <div class="absolute z-10 w-full bg-white dark:bg-gray-700 rounded-b-lg shadow-lg">
                <p wire:loading wire:target="query" class="px-2 py-1 dark:text-gray-200">
                    Searching...
                </p>
            </div>

            @if (!empty($query) && !$autocomplete)
                <div class="absolute z-10 w-full bg-white dark:bg-gray-700  rounded-b-lg shadow-lg">
                    @if (!empty($ingredients))
                        @foreach ($ingredients as $ingredient)
                            <p
                                @if ($loop->last)
                                    class="px-2 py-1 cursor-pointer rounded-b-lg hover:bg-blueGray-200 dark:text-gray-200"
                                @else
                                    class="px-2 py-1 cursor-pointer hover:bg-blueGray-200 dark:text-gray-200"
                                @endif
                                wire:click="autocomplete('{{ $ingredient['name'] }}', {{ $ingredient['id'] }})"
                            >
                                {{ $ingredient['name'] }}
                            </p>
                        @endforeach
                        @foreach ($ingredients as $ingredient)
                            @if (in_array(ucwords($query), $ingredient))
                                @break
                            @endif

                            @if ($loop->last)
                                <p class="px-2 py-1 cursor-pointer rounded-b-lg dark:text-gray-200" wire:click.prevent="createIngredient()">
                                    Add "{{ $query }}"
                                </p>
                        @endif
                        @endforeach
                    @else
                        @can ('ingredient_create')
                            <p class="px-2 py-1 cursor-pointer rounded-b-lg dark:text-gray-200" wire:click.prevent="createIngredient()">
                                No Results - Add "{{ $query }}"
                            </p>
                        @else
                            <p class="px-2 py-1 cursor-pointer rounded-b-lg dark:text-gray-200">
                                No Results
                            </p>
                        @endcan
                    @endif
                </div>
            @endif
        </div>
        <div class="md:pl-6">
            <button wire:click.prevent="add({{ $i }})" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div>
        @if (!empty($inputs))
            <ul>
                @foreach ($inputs as $key => $item)
                    <li class="font-light text-sm pt-2 md:text-base dark:text-gray-200">
                        {{ $item['quantity'] }} - {{ $item['ingredient'] }}
                        <button wire:click.prevent="remove({{ $key }})" class="w-full lg:w-auto rounded shadow-md py-1 px-2 bg-gray-400 text-white hover:bg-gray-300 text-xs">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="hidden" name="quantities[{{ $key }}]" value="{{ $item['quantity'] }}">
                        <input type="hidden" name="ingredients[{{ $key }}]" value="{{ $item['ingredientId'] }}">
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
