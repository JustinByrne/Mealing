@php
    $classes = 'block px-5 py-2 hover:text-orange-300 hover:bg-gray-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>