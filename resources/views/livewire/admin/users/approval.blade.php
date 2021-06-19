<div>
    @if ($user->approved != 1)
        <button wire:click="approve" class="w-full lg:w-auto rounded shadow-md py-1 px-2 bg-green-700 text-white hover:bg-green-500 text-xs">
            Approve
        </button>
    @endif
</div>
