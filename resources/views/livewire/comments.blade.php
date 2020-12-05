<div>
    @foreach ($comments as $comment)
        {!! $comment->comment !!}
        {{ $comment->user->name }}
    @endforeach
</div>
