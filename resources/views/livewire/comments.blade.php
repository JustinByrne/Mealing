<div wire:poll.750ms>
    @if (!$meal->hasCommentsFromUser())
    <form wire:submit.prevent="addComment">
        <div class="pb-6 text-right">    
            <textarea wire:model="comment" class="w-full p-4 bg-gray-200 appearance-none border-2 border-gray-200 rounded text-gray-700 leading-tight focus:outline-none focus:bg-white"></textarea>
            <x-inputs.button type="submit" class="justify-items-end">Comment</x-inputs.button>
        </div>
    </form>
    @endif
    
    @if (!$meal->comments()->exists())
        <p class="text-base font-light leading-relaxed mt-0 mb-4 text-lightGray-800">
            No ones left a comment about this meal. Go ahead, tell everyone if it's tasty!
        </p>
    @endif

    @foreach ($meal->comments as $comment)
        <div class="flex flex-row bg-white shadow rounded p-4 mb-4">
            <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-blue-100">
                <img class="rounded-full w-10 h-10" src="https://www.gravatar.com/avatar/{{ md5($comment->user->email) }}?s=40" alt="{{ $comment->user->name }}">
            </div>
            <div class="flex flex-col flex-grow ml-4">
                <div class="text-xs font-light text-gray-500 pb-1">{{ $comment->user->name }} - <span class="italic">{!! $comment->created_at !!}</span></div>
                <div class="text-sm font-light leading-relaxed mt-0 text-lightGray-800">{!! $comment->comment !!}</div>
            </div>
        </div>
    @endforeach
</div>
