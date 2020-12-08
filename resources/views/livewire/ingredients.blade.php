<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <x-th>Ingredient</x-th>
            <x-th>Number of Meals</x-th>
            <x-th></x-th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($ingredients as $ingredient)
            <tr>
                <x-td>{{ $ingredient->name }}</x-td>
                <x-td>{{ $ingredient->meals()->count() }}</x-td>
                <x-td class="text-right font-medium">
                    <div class="inline-flex">
                        <a href="{{ $ingredient->path() }}" class="px-2 py-1 text-blueGray-600 font-medium hover:text-orange-500">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if ($ingredient->user->id == Auth::Id())
                            <a href="{{ $ingredient->path() }}/edit" class="px-2 py-1 text-blueGray-600 font-medium hover:text-lime-600">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ $ingredient->path() }}" method="POST">
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