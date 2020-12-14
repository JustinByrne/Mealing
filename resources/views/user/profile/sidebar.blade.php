@section('side-links')
    <x-links.sidebar href="{{ route('profile') }}" :active="request()->routeIs('profile')">
        Profile
    </x-links.sidebar>
@endsection