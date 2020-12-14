@section('side-links')
    <x-links.sidebar href="{{ route('profile') }}" :active="request()->routeIs('profile')">
        Profile
    </x-links.sidebar>
    <x-links.sidebar href="{{ route('profile.settings') }}" :active="request()->routeIs('profile.settings*')">
        Settings
    </x-links.sidebar>
@endsection