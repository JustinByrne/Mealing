@extends('layouts.app')

@section('title', $role->name . ' Role - Admin')

@include('admin.sidebar')

@section('content')
    <div>
        <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">
            {{ $role->name }} Role
        </h1>
        <hr class="border-b border-gray-400">
    </div>

    <h2 class="font-sans break-normal text-gray-900 pt-3 text-base font-bold">
        Permissions
    </h2>

    @if ($role->permissions()->count() != 0)
        <div>
            <div class="flex flex-col mt-5">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="bg-white border border-gray-200">
                                    @foreach ($role->permissions->chunk(5) as $row)
                                        <tr>
                                            @foreach ($row as $permission)
                                                <x-table.td class="bg-white border border-gray-200 w-1/5">
                                                    {{ $permission->name }}
                                                </x-table.td>
                                                @if ($loop->parent->last)
                                                    @for ($i = $loop->count; $i < 5; $i++)
                                                        <x-table.td class="bg-white border border-gray-200 w-1/5" />
                                                    @endfor
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>
            This role has no permissions assigned to it
        </p>
    @endif
@endsection