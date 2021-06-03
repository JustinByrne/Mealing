@extends('admin.layout')

@section('title', 'All Users')

@section('admin.content')
<div class="w-full p-4 bg-white border-b border-gray-200 rounded-t-md dark:bg-gray-700">
    <p class="font-bold dark:text-gray-200">
        All Users
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
                    Email
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @if ($loop->odd)
                    <tr class="hover:bg-green-600 hover:bg-opacity-10">
                @else
                    <tr class="bg-green-600 bg-opacity-5 hover:bg-opacity-10">
                @endif
                    <td class="block lg:table-cell px-4 py-2">
                        {{ $user->name }}
                    </td>
                    <td class="block lg:table-cell px-4 py-2">
                        {{ $user->email }}
                    </td>
                    <td class="flex flex-col lg:flex-row px-4 py-2 lg:justify-end space-y-1 lg:space-y-0 lg:space-x-1">
                        @livewire('admin.users.approval', ['user' => $user])
                        <div>
                            <a href="{{ route('admin.users.edit', $user) }}">
                                <button class="w-full lg:w-auto rounded shadow-md py-1 px-2 bg-green-600 text-white hover:bg-green-500 text-xs">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                            </a>
                        </div>
                        <div>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="w-full lg:w-auto rounded shadow-md py-1 px-2 bg-gray-400 text-white hover:bg-gray-300 text-xs">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection