<button {!! $attributes->merge(['class' => 'shadow bg-blue-500 text-white font-bold py-2 px-4 mb-2 rounded w-full md:w-auto hover:bg-blue-400']) !!}>
    {{ $slot }}
</button>