<div>
    <div class="space-y-4">
        <x-inputs.text placeholder="Amount" wire:model="quantity"/>
        <x-inputs.select wire:model="ingredient">
            @foreach ($ingredients as $ingredient)
                <option value="{{ $ingredient->name }}">
                    {{ $ingredient->name }}
                </option>
            @endforeach
        </x-inputs.select>
        <x-inputs.button wire:click.prevent="add({{ $i }})">
            <i class="fas fa-plus"></i>
        </x-inputs.button>
        @dump($inputs)
    </div>
</div>
