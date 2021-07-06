<div class="rating text-center">
    @for ($i = 5; $i > 0; $i--)
        @if ($score >= $i)
            <i class="fas fa-star cursor-pointer text-yellow-500 text-2xl lg:text-lg" wire:click="rate({{ $i }})"></i>
        @else
            <i class="far fa-star cursor-pointer text-yellow-500 text-2xl lg:text-lg" wire:click="rate({{ $i }})"></i>
        @endif
    @endfor
</div>
