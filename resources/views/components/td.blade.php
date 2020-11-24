@php
    $classes = 'px-6 py-4 whitespace-nowrap text-sm text-gray-900';
@endphp

<td {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</td>