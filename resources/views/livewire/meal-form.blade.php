<div>
    <div class="space-y-4">
        <x-inputs.text placeholder="Amount" wire:model="quantity"/>
        <x-inputs.text placeholder="Search Ingredients..." wire:model.debounce.300ms="query" />
        <x-inputs.button wire:click.prevent="add({{ $i }})">
            <i class="fas fa-plus"></i>
        </x-inputs.button>
        @dump($ingredients)
    </div>
</div>
