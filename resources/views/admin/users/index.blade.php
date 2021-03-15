@extends('layouts.app')

@section('title', 'Users - Admin')

@include('admin.sidebar')

@section('content')
<div class="font-sans">
    <div class="flex justify-between">
        <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">
            Users
        </h1>
    </div>
    <hr class="border-b border-gray-400">
</div>

<div class="flex flex-col mt-5">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <x-table.th>
                                Name
                            </x-table.th>
                            <x-table.th>
                                Email
                            </x-table.th>
                            <x-table.th></x-table.th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr>
                                <x-table.td>
                                    {{ $user->name }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $user->email }}
                                </x-table.td>
                                <x-table.td class="flex space-x-2">
                                    @can ('user_edit')
                                        <a href="{{ route('admin.users.edit', [$user]) }}">
                                            <x-inputs.button>
                                                <i class="fas fa-pencil-alt"></i>
                                            </x-inputs.button>
                                        </a>
                                    @endcan
                                    @can ('user_delete')
                                        <form action="{{ route('admin.users.destroy', [$user]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-inputs.button color="bg-red-400 hover:bg-red-300">
                                                <i class="fas fa-trash"></i>
                                            </x-inputs.button>
                                        </form>
                                    @endcan
                                </x-table.td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection