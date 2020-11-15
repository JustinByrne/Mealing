@props(['active'])

@php
$classes = ($active ?? false)
            ? 'lg:p-4 py-3 px-0 block border-b-2 border-indigo-400 transition duration-300 ease-in-out focus:outline-none'
            : 'lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-indigo-400 transition duration-300 ease-in-out focus:outline-none'
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>