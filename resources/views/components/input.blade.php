@props(['disabled' => false, 'error'])

@php
    $classes = ($error ?? false)
                ? 'bg-red-200 appearance-none border-2 border-red-400 rounded w-full py-2 px-4 text-blueGray-700 leading-tight focus:outline-none focus:bg-white focus:border-red-500'
                : 'bg-blueGray-200 appearance-none border-2 border-blueGray-200 rounded w-full py-2 px-4 text-blueGray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500'
@endphp

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $classes]) !!}>