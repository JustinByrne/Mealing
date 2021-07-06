<div class="rating group">
    @for ($i = 5; $i > 0; $i--)
        @if ($score >= $i)
            <i class="fas fa-star cursor-pointer text-yellow-500" wire:click="rate({{ $i }})"></i>
        @else
            <i class="far fa-star cursor-pointer text-yellow-500" wire:click="rate({{ $i }})"></i>
        @endif
    @endfor
</div>
