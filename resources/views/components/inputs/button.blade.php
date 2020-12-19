<button {!! $attributes->merge(['class' => 'shadow bg-blue-500 text-white font-bold py-2 px-4 rounded w-full md:w-auto hover:bg-blue-400 focus:shadow-outline focus:outline-none']) !!}>
    {{ $slot }}
</button>