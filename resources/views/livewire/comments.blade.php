<div>
    <div class="space-y-4">
        @if (!$recipe->comments()->exists())
            <div class="bg-blue-400 bg-opacity-20 text-blue-700 border-l-4 border-blue-400 py-3 px-4 dark:bg-opacity-40 dark:text-blue-300">
                <i class="fas fa-info-circle mr-1"></i> No ones left a comment about this recipe. Go ahead, tell everyone if it's tasty!
            </div>
        @endif
    
        @if (!$recipe->hasCommentsFromUser())
        <form wire:submit.prevent="addComment">
            <textarea wire:model="comment" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-1/2 h-32 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200"></textarea>
            <div>
                <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
                    Comment
                </button>
            </div>
        </form>
        @endif
    
        @foreach ($recipe->comments as $comment)
            <div class="flex flex-row bg-gray-50 dark:bg-gray-600 shadow rounded p-4 mb-4">
                <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl">
                    <img class="rounded-full w-10 h-10" src="https://www.gravatar.com/avatar/{{ md5($comment->user->email) }}?s=40" alt="{{ $comment->user->name }}">
                </div>
                <div class="flex flex-col flex-grow ml-4">
                    <div class="text-xs font-light text-gray-500 dark:text-gray-300 pb-1">{{ $comment->user->name }} - <span class="italic">{!! $comment->created_at !!}</span></div>
                    <div class="text-sm font-light dark:text-gray-200 leading-relaxed mt-0 text-lightGray-800">{!! $comment->comment !!}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
