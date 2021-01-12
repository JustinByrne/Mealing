@section('side-links')
    <div>
        <x-links.sidebar href="{{ route('roles.index') }}" :active="request()->routeIs('roles*')">
            Roles
        </x-links.sidebar>
        <div>
            <x-links.sidebar href="{{ route('roles.create') }}" :active="request()->routeIs('roles.create')">
                <span class="font-bold mr-2">-</span> Create New Role
            </x-links.sidebar>
        </div>
    </div>
@endsection