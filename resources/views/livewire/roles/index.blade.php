<div>
    <div class="w-full p-4 bg-white border-b border-gray-200 rounded-t-md dark:bg-gray-700">
        <p class="font-bold dark:text-gray-200">
            All Roles
        </p>
    </div>
    <div class="p-4">
        <table class="w-full dark:text-gray-200">
            <thead>
                <tr class="hidden lg:table-row border-b">
                    <th class="text-left px-4 py-2 w-1/3">
                        Name
                    </th>
                    <th class="text-left px-4 py-2 w-1/3">
                        # of Users
                    </th>
                    <th class="text-left px-4 py-2 w-1/3">
                        # Permissions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    @if ($loop->odd)
                        <tr class="hover:bg-green-600 hover:bg-opacity-10">
                    @else
                        <tr class="bg-green-600 bg-opacity-5 hover:bg-opacity-10">
                    @endif
                        <td class="block lg:table-cell px-4 py-2">
                            <a href="{{ route('admin.roles.show', $role) }}" class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                                {{ $role->name }}
                            </a>
                        </td>
                        <td class="block lg:table-cell px-4 py-2">
                            {{ $role->users->count()}}
                        </td>
                        <td class="block lg:table-cell px-4 py-2">
                            {{ $role->permissions->count()}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $roles->links() }}
        </div>
    </div>
</div>