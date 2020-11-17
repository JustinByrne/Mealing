@props(['active'])

@php
$classes = ($active ?? false)
            ? 'lg:p-4 py-3 px-0 block border-b-2 border-orange-300 hover:text-orange-300'
            : 'lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-orange-300 hover:text-orange-300'
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>