<div>
    <div class="items-top space-y-4 md:space-y-0 md:grid md:grid-cols-9 md:space-x-6">
        <div>
            <x-inputs.text placeholder="Amount" wire:model="quantity" />
        </div>
        <div class="w-full md:col-span-4">
            <x-inputs.text placeholder="Search Ingredients..." wire:model.debounce.300ms="query" />
        </div>
        <div class="md:pl-6">
            <x-inputs.button wire:click.prevent="add({{ $i }})">
                <i class="fas fa-plus"></i>
            </x-inputs.button>
        </div>
    </div>
    <div class="space-y-4">
        @dump($ingredients)
    </div>
</div>
