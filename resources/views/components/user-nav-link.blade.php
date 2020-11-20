@php
    $classes = 'block px-4 py-2 mx-1 rounded-lg hover:text-orange-300 hover:bg-gray-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>