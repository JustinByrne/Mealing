<div>
    <div class="font-sans">
        <div class="flex justify-between">
            <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">
                Roles
            </h1>
            <div class="pt-3">
                <div class="flex w-full justify-end">
                    <div class="relative text-gray-600 focus-within:text-gray-400">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2">
                            <button class="p-1 focus:outline-none focus:shadow-outline">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                        <input class="py-2 text-sm rounded-md pl-2 pr-10 border-2 focus:outline-none focus:text-gray-900" placeholder="Search..." autocomplete="off" wire:model.debounce.300ms="search">
                    </div>
                </div>
            </div>
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
                                    Description
                                </x-table.th>
                                <x-table.th>
                                    # of Users
                                </x-table.th>
                                <x-table.th>
                                    # of Permissions
                                </x-table.th>
                                <x-table.th></x-table.th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($roles as $role)
                                <tr>
                                    <x-table.td>
                                        {{ $role->title }}
                                    </x-table.td>
                                    <x-table.td>
                                        {{ $role->description }}
                                    </x-table.td>
                                    <x-table.td>
                                        {{ $role->users->count()}}
                                    </x-table.td>
                                    <x-table.td>
                                        {{ $role->permissions->count()}}
                                    </x-table.td>
                                    <x-table.td></x-table.td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
