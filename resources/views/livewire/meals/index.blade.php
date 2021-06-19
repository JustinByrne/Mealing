<div class="flex flex-col lg:flex-row lg:space-x-6">
    <div class="w-full lg:w-4/5 order-2 lg:order-1">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-5">
            @foreach ($meals as $meal)
                <a href="{{ route('meals.show', $meal) }}">
                    <div class="w-full rounded-md shadow-md dark:bg-gray-700">
                        <div>
                            @if ($meal->getMedia()->count() > 0)
                                <img src="{{ $meal->getFirstMediaUrl('default', 'thumb') }}" class="w-full h-32 object-cover rounded-t-md" alt="{{ $meal->name }}">
                            @else
                                <img src="https://via.placeholder.com/640x360.png?text=No+Image" class="w-full max-h-32 object-cover rounded-t-md" alt="No image available">
                            @endif
                        </div>
                        <div class="bg-white p-4 rounded-b-md dark:bg-gray-700 dark:text-gray-200 space-y-2">
                            <p>
                                {{ $meal->name }}
                            </p>
                            <p class="text-sm text-yellow-400" title="{{ $meal->avg_rating > 0 ? $meal->avg_rating : '0' }}">
                                @for ($x = 0; $x < 5; $x++)
                                    @if (floor($meal->avg_rating)-$x >= 1)
                                        <i class="fas fa-star"></i>
                                    @elseif ($meal->avg_rating-$x > 0)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </p>
                            <p>
                                Serves: {{ $meal->servings }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        {{ $meals->links() }}
    </div>
    <div class="w-full lg:w-1/5 order-1 mb-3 lg:mb-0" x-data="{open: false}">
        <div class="w-full rounded-md shadow-md bg-white dark:bg-gray-700">
            <div class="flex justify-between p-4 border-b border-gray-200">
                <p class="font-bold dark:text-gray-200 self-center">
                    Filter
                </p>
                <div class="lg:hidden">
                    <button class="border border-gray-100 px-2 pt-1 rounded-lg dark:text-gray-200" @click="open = !open">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
            {{-- <div class="hidden lg:block" :class="{'hidden': !open}">
                <div class="p-4">
                    <div class="flex flex-row justify-between">
                        <div class="font-bold mb-3 dark:text-gray-200">
                            Rating
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <p class="dark:text-gray-200">
                            <input type="checkbox" checked class="rounded mr-2 text-green-700 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200 dark:focus:bg-green-700">
                            All
                        </p>
                        <p class="dark:text-gray-200">
                            <input type="checkbox" class="rounded mr-2 text-green-700 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200 dark:focus:bg-green-700">
                            <span class="text-sm text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </span>
                        </p>
                        <p class="dark:text-gray-200">
                            <input type="checkbox" class="rounded mr-2 text-green-700 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200 dark:focus:bg-green-700">
                            <span class="text-sm text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </span>
                        </p>
                        <p class="dark:text-gray-200">
                            <input type="checkbox" class="rounded mr-2 text-green-700 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200 dark:focus:bg-green-700">
                            <span class="text-sm text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </span>
                        </p>
                        <p class="dark:text-gray-200">
                            <input type="checkbox" class="rounded mr-2 text-green-700 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200 dark:focus:bg-green-700">
                            <span class="text-sm text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </span>
                        </p>
                        <p class="dark:text-gray-200">
                            <input type="checkbox" class="rounded mr-2 text-green-700 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200 dark:focus:bg-green-700">
                            <span class="text-sm text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <hr class="mx-3">
                <div class="grid grid-cols-2 gap-4 p-4">
                    <button class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
                        Filter
                    </button>
                    <button class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-gray-400 text-white hover:bg-gray-300">
                        Clear
                    </button>
                </div>
            </div> --}}
        </div>
    </div>
</div>