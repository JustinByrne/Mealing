<div>
    @if( $meal->getMedia()->count() > 0)
        <div class="flex items-center space-x-2">
            <img src="{{ $meal->getFirstMediaUrl() }}" class="h-16 rounded">
            <span class="text-red-500 cursor-pointer" wire:click="delete">
                <i class="fas fa-times"></i>
            </span>
        </div>
    @else
        <div x-data x-init="
            FilePond.create($refs.input);
            FilePond.setOptions({
                server: {
                    url: '/upload',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });
        ">
            <input type="file" name="image" x-ref="input">
        </div>
    @endif
</div>
