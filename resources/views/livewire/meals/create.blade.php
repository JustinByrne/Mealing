<div>
    <div class="items-top space-y-4 md:space-y-0 md:grid md:grid-cols-9 md:space-x-6">
        <div>
            <x-inputs.text placeholder="Amount" wire:model="quantity" :error="$errors->has('quantity')" />
        </div>
        <div class="w-full relative md:col-span-4">
            <x-inputs.text placeholder="Search Ingredients..." wire:model.debounce.300ms="query" wire:keydown.escape="resetQuery" wire:keydown.tab="resetQuery" class="z-10" :error="$errors->has('query')" />
            
            <div class="absolute z-10 w-full bg-white rounded-b-lg shadow-lg">
                <p wire:loading wire:target="query" class="px-2 py-1">
                    Searching...
                </p>
            </div>

            @if (!empty($query) && !$autocomplete)
                <div class="absolute z-10 w-full bg-white rounded-b-lg shadow-lg">
                    @if (!empty($ingredients))
                        @foreach ($ingredients as $ingredient)
                            <p
                                @if ($loop->last)
                                    class="px-2 py-1 cursor-pointer rounded-b-lg hover:bg-blueGray-200"
                                @else
                                    class="px-2 py-1 cursor-pointer hover:bg-blueGray-200"
                                @endif
                                wire:click="autocomplete('{{ $ingredient['name'] }}', {{ $ingredient['id'] }})"
                            >
                                {{ $ingredient['name'] }}
                            </p>
                        @endforeach
                    @else
                        <p class="px-2 py-1 cursor-pointer rounded-b-lg">
                            No results...
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <div class="md:pl-6">
            <x-inputs.button wire:click.prevent="add({{ $i }})">
                <i class="fas fa-plus"></i>
            </x-inputs.button>
        </div>
    </div>
    <div>
        @if (!empty($inputs))
            <ul>
                @foreach ($inputs as $key => $item)
                    <li class="font-light text-xs md:pt-2 md:text-base">
                        {{ $item['quantity'] }} - {{ $item['ingredient'] }}
                        <button class="shadow bg-red-500 text-white font-bold py-1 px-1.5 text-xs mb-2 rounded w-full md:w-auto hover:bg-red-400" wire:click.prevent="remove({{ $key }})">
                            <i class="fas fa-minus"></i>
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
