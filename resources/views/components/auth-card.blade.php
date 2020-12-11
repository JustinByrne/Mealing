@props(['title' => 'Mealing'])

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-lg overflow-hidden sm:rounded-lg">
        <h1 class="text-center text-xl pb-8">{{ $title }}</h1>
        {{ $slot }}
    </div>
</div>