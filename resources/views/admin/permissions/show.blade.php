@extends('admin.layout')

@section('admin.content')
<div class="w-full p-4 bg-white border-b border-gray-200 rounded-t-md dark:bg-gray-700">
    <p class="font-bold dark:text-gray-200">
        {{ $permission->name }} Permission
    </p>
</div>
<div class="p-4">
    <p class="font-bold mb-5 dark:text-gray-200">
        Roles
    </p>
    @if ($permission->roles()->count() != 0)
        <table class="w-full dark:text-gray-200">
            <thead>
                <tr class="hidden lg:table-row border-b">
                    <th class="text-left px-4 py-2 w-1/3">
                        Name
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permission->roles as $role)
                    @if ($loop->odd)
                        <tr class="hover:bg-green-700 hover:bg-opacity-10">
                    @else
                        <tr class="bg-green-700 bg-opacity-5 hover:bg-opacity-10">
                    @endif
                        <td class="block lg:table-cell px-4 py-2">
                            <a href="{{ route('admin.roles.show', $role) }}" class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                                {{ $role->name }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="mb-5 dark:text-gray-200">
            This permission is not connected to any Roles
        </p>
    @endif
</div>
@endsection