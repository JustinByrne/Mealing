@section('side-links')
    <x-links.sidebar href="{{ route('profile') }}" :active="request()->routeIs('profile')">
        Profile
    </x-links.sidebar>

    <div
        @if (request()->routeIs('profile.settings*'))
            x-data="{ isOpen: true }"
        @else
            x-data="{ isOpen: false }"
        @endif
    >
        <x-links.sidebar class="cursor-pointer" :active="request()->routeIs('profile.settings*')" @click="isOpen = !isOpen">
            Settings
        </x-links.sidebar>
        <div x-show="isOpen">
            <x-links.sidebar href="{{ route('profile.settings.account') }}" :active="request()->routeIs('profile.settings.account')" class="ml-4 text-base">
                <span class="font-bold mr-2">-</span> Account
            </x-links.sidebar>
            <x-links.sidebar href="{{ route('profile.settings.security') }}" :active="request()->routeIs('profile.settings.security')" class="ml-4 text-base">
                <span class="font-bold mr-2">-</span> Security
            </x-links.sidebar>
        <div>
    </div>
@endsection