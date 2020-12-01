@props(['rating'])

<span title="{{ $rating }}">
    @foreach(range(1,5) as $i)
        
        @if($rating > 0)
            @if($rating > 0.5)
                <i class="fas fa-star text-orange-400"></i>
            @else
                <i class="fas fa-star-half-alt text-orange-400"></i>
            @endif
        @else
            <i class="far fa-star text-orange-400"></i>
        @endif
        
        @php
            $rating--;
        @endphp

    @endforeach
</span>