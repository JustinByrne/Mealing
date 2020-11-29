@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'px-3 py-5 text-gray-100 border-b-2 bg-gray-900 border-orange-300 lg:inline-flex lg:w-auto hover:text-orange-300'
        : 'px-3 py-5 text-gray-400 border-b-2 border-transparent hover:bg-gray-900 hover:text-orange-300 hover:border-orange-300 lg:inline-flex lg:w-auto'
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>