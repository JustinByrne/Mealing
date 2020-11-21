@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'px-3 py-5 text-blueGray-400 border-b-2 border-transparent bg-blueGray-900 hover:text-orange-300 hover:border-orange-300 lg:inline-flex lg:w-auto'
        : 'px-3 py-5 text-blueGray-400 border-b-2 border-transparent hover:bg-blueGray-900 hover:text-orange-300 hover:border-orange-300 lg:inline-flex lg:w-auto'
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>