@props(['color' => null])

@switch($color)
    @case('gray')
        <span class="bg-gray-100 py-1 px-3.5 text-blueGray-700 font-medium text-sm rounded-full">        
        @break
    @case('red')
        <span class="bg-red-100 py-1 px-3.5 text-red-800 font-medium text-sm rounded-full">
        @break
    @case('orange')
        <span class="bg-orange-100 py-1 px-3.5 text-orange-800 font-medium text-sm rounded-full">
        @break
    @case('yellow')
        <span class="bg-yellow-100 py-1 px-3.5 text-yellow-800 font-medium text-sm rounded-full">
        @break
    @case('green')
        <span class="bg-green-100 py-1 px-3.5 text-green-800 font-medium text-sm rounded-full">
        @break
    @case('teal')
        <span class="bg-teal-100 py-1 px-3.5 text-teal-800 font-medium text-sm rounded-full">
        @break
    @case('lightBlue')
        <span class="bg-lightBlue-100 py-1 px-3.5 text-lightBlue-800 font-medium text-sm rounded-full">
        @break
    @case('indigo')
        <span class="bg-indigo-100 py-1 px-3.5 text-indigo-800 font-medium text-sm rounded-full">
        @break
    @case('purple')
        <span class="bg-purple-100 py-1 px-3.5 text-purple-800 font-medium text-sm rounded-full">
        @break
    @case('rose')
        <span class="bg-rose-100 py-1 px-3.5 text-rose-800 font-medium text-sm rounded-full">
        @break
    @default
        <span class="bg-gray-100 py-1 px-3.5 text-blueGray-700 font-medium text-sm rounded-full">
@endswitch
    {{ $slot }}
</span>