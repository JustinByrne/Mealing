<div>
    <div class="items-top space-y-4 md:space-y-0 md:grid md:grid-cols-9 md:space-x-6">
        <div>
            <x-inputs.text placeholder="Amount" wire:model="quantity" />
        </div>
        <div class="w-full relative md:col-span-4">
            <x-inputs.text placeholder="Search Ingredients..." wire:model.debounce.300ms="query" wire:keydown.escape="resetQuery" wire:keydown.tab="resetQuery" class="z-10" />

            <div class="absolute z-10 w-full bg-white rounded-b-lg shadow-lg">
                <p wire:loading class="px-2 py-1">
                    Searching...
                </p>
            </div>

            @if (!empty($query))
                <div class="absolute z-10 w-full bg-white rounded-b-lg shadow-lg">
                    @if (!empty($ingredients))
                        @foreach ($ingredients as $ingredient)
                            @if ($loop->last)
                                <p class="px-2 py-1 cursor-pointer rounded-b-lg hover:bg-blueGray-200">
                            @else
                                <p class="px-2 py-1 cursor-pointer hover:bg-blueGray-200">
                            @endif
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
</div>
