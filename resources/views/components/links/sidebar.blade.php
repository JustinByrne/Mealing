@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'block pl-4 align-middle text-white no-underline border-l-4 border-orange-400 font-bold hover:text-orange-300'
        : 'block pl-4 align-middle text-white no-underline border-l-4 border-transparent font-bold hover:border-orange-400 hover:text-orange-300'
@endphp

<li class="py-2 md:my-0">
    <a {{ $attributes->merge(['class' => $classes]) }}>
        <span class="pb-1 md:pb-0 text-sm">{{ $slot }}</span>
    </a>
</li>