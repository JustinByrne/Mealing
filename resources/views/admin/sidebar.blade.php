@section('side-links')
    @can ('user_access')
        <div>
            <x-links.sidebar href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users*')">
                Users
            </x-links.sidebar>
            <div>
                @can ('user_create')
                    <x-links.sidebar href="{{ route('admin.users.create') }}" :active="request()->routeIs('admin.users.create')">
                        <span class="font-bold mr-2">-</span> Create New User
                    </x-links.sidebar>
                @endcan
            </div>
        </div>
    @endcan
    @can ('ingredient_access')
        <div>
            <x-links.sidebar href="{{ route('admin.ingredients.index') }}" :active="request()->routeIs('admin.ingredients*')">
                Ingredients
            </x-links.sidebar>
            <div>
                @can ('Ingredient_create')
                    <x-links.sidebar href="{{ route('admin.ingredients.create') }}" :active="request()->routeIs('admin.ingredients.create')">
                        <span class="font-bold mr-2">-</span> Create New Ingredients
                    </x-links.sidebar>
                @endcan
            </div>
        </div>
    @endcan
    @can ('role_access')
        <div>
            <x-links.sidebar href="{{ route('admin.roles.index') }}" :active="request()->routeIs('admin.roles*')">
                Roles
            </x-links.sidebar>
            <div>
                @can ('role_create')
                    <x-links.sidebar href="{{ route('admin.roles.create') }}" :active="request()->routeIs('admin.roles.create')">
                        <span class="font-bold mr-2">-</span> Create New Role
                    </x-links.sidebar>
                @endcan
            </div>
        </div>
    @endcan
    @can ('permission_access')
        <div>
            <x-links.sidebar href="{{ route('admin.permissions.index') }}" :active="request()->routeIs('admin.permissions*')">
                Permissions
            </x-links.sidebar>
            <div>
                @can ('permission_create')
                    <x-links.sidebar href="{{ route('admin.permissions.create') }}" :active="request()->routeIs('admin.permissions.create')">
                        <span class="font-bold mr-2">-</span> Create New Permission
                    </x-links.sidebar>
                @endcan
            </div>
        </div>
    @endcan
@endsection