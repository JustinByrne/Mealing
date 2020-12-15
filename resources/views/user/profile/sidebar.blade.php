@section('side-links')
    <x-links.sidebar href="{{ route('profile') }}" :active="request()->routeIs('profile')">
        Profile
    </x-links.sidebar>
    <x-links.sidebar href="{{ route('profile.settings') }}" :active="request()->routeIs('profile.settings*')">
        Settings
    </x-links.sidebar>
    @if (request()->routeIs('profile.settings*'))
        <x-links.sidebar href="{{ route('profile.settings.security') }}" :active="request()->routeIs('profile.settings.security')" class="ml-4 text-base">
            <span class="font-bold mr-2">-</span> Security
        </x-links.sidebar>
    @endif
@endsection