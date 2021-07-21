<div>
    @if ($user->approved != 1 && ! is_null($user->email_verified_at))
        <button wire:click="approve" class="w-full lg:w-auto rounded shadow-md py-1 px-2 bg-green-700 text-white hover:bg-green-500 text-xs">
            Approve
        </button>
    @elseif (is_null($user->email_verified_at))
        <span class="w-full lg:w-auto rounded shadow-md py-1 px-2 bg-green-700 text-white hover:bg-green-500 text-xs">
            Not Verified
        </span>
    @endif
</div>
