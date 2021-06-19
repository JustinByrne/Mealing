<div>
    <div class="w-full p-4 bg-white border-b border-gray-200 rounded-t-md dark:bg-gray-700">
        <p class="font-bold dark:text-gray-200">
            All Permissions
        </p>
    </div>
    <div class="p-4">
        <table class="w-full dark:text-gray-200">
            <thead>
                <tr class="hidden lg:table-row border-b">
                    <th class="text-left px-4 py-2 w-1/3">
                        Name
                    </th>
                    <th class="text-left px-4 py-2 w-2/3">
                        Roles
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    @if ($loop->odd)
                        <tr class="hover:bg-green-700 hover:bg-opacity-10">
                    @else
                        <tr class="bg-green-700 bg-opacity-5 hover:bg-opacity-10">
                    @endif
                        <td class="block lg:table-cell px-4 py-2">
                            <a href="{{ route('admin.permissions.show', $permission) }}" class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                                {{ $permission->name }}
                            </a>
                        </td>
                        <td class="block lg:table-cell px-4 py-2 space-x-2">
                            <span class="bg-purple-100 py-1 px-3.5 text-purple-800 font-medium text-sm rounded-full">
                                Super Admin
                            </span>
                            @foreach ($permission->roles as $role)
                                <span class="bg-blue-100 py-1 px-3.5 text-blue-800 font-medium text-sm rounded-full">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $permissions->links() }}
        </div>
    </div>
</div>