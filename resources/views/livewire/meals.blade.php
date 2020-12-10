<div>
    <div class="font-sans">
        <div class="flex justify-between">
            <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">Meals</h1>
            <div class="pt-3">
                <div class="flex w-full justify-end">
                    <div class="relative text-gray-600 focus-within:text-gray-400">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2">
                            <button class="p-1 focus:outline-none focus:shadow-outline">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                        <input class="py-2 text-sm rounded-md pl-2 pr-10 border-2 focus:outline-none focus:text-gray-900" placeholder="Search..." autocomplete="off" wire:model="search">
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
                                <x-th>Meal</x-th>
                                <x-th>Servings</x-th>
                                <x-th>Timing</x-th>
                                <x-th>Rating</x-th>
                                <x-th></x-th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($meals as $meal)
                                <tr>
                                    <x-td>
                                        <a href="{{ $meal->path() }}" class="hover:text-orange-500 hover:underline">
                                            {{ $meal->name }}
                                        </a>
                                    </x-td>
                                    <x-td>{{ $meal->servings }}</x-td>
                                    <x-td>{{ $meal->readable_timing }}</x-td>
                                    <x-td><x-rating :rating="$meal->ratings()->avg('score')"></x-rating></x-td>
                                    <x-td class="text-right font-medium">
                                        <div class="inline-flex">
                                            <a href="{{ $meal->path() }}" class="px-2 py-1 text-blueGray-600 font-medium hover:text-orange-500">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($meal->user->id == Auth::Id())
                                                <a href="{{ $meal->path() }}/edit" class="px-2 py-1 text-blueGray-600 font-medium hover:text-lime-600">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{ $meal->path() }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1 text-blueGray-600 font-medium hover:text-red-700">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </x-td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
