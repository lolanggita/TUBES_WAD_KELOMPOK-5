@if ($event->comments->isEmpty())
    <p class="text-gray-500 italic mt-4" id="no-comments">Belum ada komentar.</p>
@endif

@foreach ($event->comments as $comment)
    <div class="border-b border-gray-200 pb-4 mb-4 comment-item">
        <div class="flex items-center mb-2">
            <span class="text-sm font-medium text-gray-800">{{ $comment->user->name }}</span>
            <span class="text-xs text-gray-500 ml-2">
                {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
            </span>
        </div>
        <p class="text-gray-700">{{ $comment->content }}</p>
    </div>
@endforeach