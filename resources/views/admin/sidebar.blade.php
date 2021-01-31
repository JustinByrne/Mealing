@section('side-links')
    <div>
        <x-links.sidebar href="{{ route('admin.roles.index') }}" :active="request()->routeIs('admin.roles*')">
            Roles
        </x-links.sidebar>
        <div>
            <x-links.sidebar href="{{ route('admin.roles.create') }}" :active="request()->routeIs('admin.roles.create')">
                <span class="font-bold mr-2">-</span> Create New Role
            </x-links.sidebar>
        </div>
    </div>
    <div>
        <x-links.sidebar href="{{ route('admin.permissions.index') }}" :active="request()->routeIs('admin.permissions*')">
            Permissions
        </x-links.sidebar>
        <div>
            <x-links.sidebar href="{{ route('admin.permissions.create') }}" :active="request()->routeIs('admin.permissions.create')">
                <span class="font-bold mr-2">-</span> Create New Permission
            </x-links.sidebar>
        </div>
    </div>
@endsection