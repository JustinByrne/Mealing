<div class="mb-5">
    <div class="flex justify-end mb-3">
        <button type="button" wire:click="randomizeAll" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
            <i class="fas fa-sync-alt"></i>
            Randomize
        </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 gap-2">
        @if (! is_null($meals))
            @for ($i = 0; $i < 7; $i++)
                <div class="rounded shadow bg-white dark:bg-gray-700">
                    <div class="text-center font-bold dark:text-gray-200 py-3 capitalize">
                        {{ $days[$i] }}
                    </div>
                    <div>
                        @if( $meals[$i]->getMedia()->count() > 0)
                            <img src="{{ $meals[$i]->getFirstMediaUrl() }}" class="w-full h-48 object-cover">
                        @else
                            <img src="https://via.placeholder.com/640x360.png?text=No+Image" class="w-full h-48 object-cover">
                        @endif
                    </div>
                    <div class="p-2">
                        <p class="mb-1 dark:text-gray-200">
                            {{ $meals[$i]->name }}
                        </p>
                        <p class="text-sm text-yellow-400 mb-3" title="{{ $meals[$i]->avg_rating > 0 ? $meals[$i]->avg_rating : '0' }}">
                            @for ($x = 0; $x < 5; $x++)
                                @if (floor($meals[$i]->avg_rating)-$x >= 1)
                                    <i class="fas fa-star"></i>
                                @elseif ($meals[$i]->avg_rating-$x > 0)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </p>
                        <p class="mb-3 dark:text-gray-200">
                            Serves: {{ $meals[$i]->servings }}
                        </p>
                        <input type="hidden" name="{{ $days[$i] }}" wire:model="mealIds.{{ $i }}">
                        <button type="button" wire:click="randomize({{ $i }})" class="w-full lg:w-auto mb-2 rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
                            <i class="fas fa-sync-alt"></i>
                            Change
                        </button>
                    </div>
                </div>
            @endfor
        @else
            @for ($i = 0; $i < 7; $i++)
                <div class="rounded shadow bg-white dark:bg-gray-700">
                    <div class="text-center font-bold dark:text-gray-200 py-3 capitalize">
                        {{ $days[$i] }}
                    </div>
                    <div class="h-48 bg-gray-300">
                    </div>
                    <div class="p-2">
                        <div class="mb-1 h-4 dark:text-gray-200 bg-gray-200"></div>
                        <div class="mb-1 h-4 dark:text-gray-200 bg-gray-200"></div>
                        <div class="mb-1 h-4 dark:text-gray-200 bg-gray-200"></div>
                    </div>
                </div>
            @endfor
        @endif
    </div>
</div>
