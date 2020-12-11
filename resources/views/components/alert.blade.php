@props(['type' => ''])

@php
    switch ($type) {
        case 'error':
            $bg = 'bg-red-200 border-red-500 text-red-700';
            break;
        case 'warn':
            $bg = 'bg-amber-200 border-amber-500 text-amber-700';
            break;
        case 'info':
            $bg = 'bg-green-200 border-green-500 text-green-700';
            break;
        default:
            $bg = 'bg-blue-200 border-blue-500 text-blue-700';
    }
@endphp

<div {!! $attributes->merge(['class' => $bg . ' w-full border-l-4 px-3 py-3 mb-3 text-sm']) !!}>
    {{ $slot }}
</div>