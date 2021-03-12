@props(['color' => 'bg-blue-500 hover:bg-blue-400'])

<button {!! $attributes->merge(['class' => 'shadow text-white font-bold py-2 px-4 mb-2 rounded w-full md:w-auto ' . $color]) !!}>
    {{ $slot }}
</button>