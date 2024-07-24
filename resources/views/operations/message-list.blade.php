@foreach($messages as $message)
    <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }} mb-4">
        @if($message->sender_id != Auth::id())
            <div class="message-avatar">
                <img src="{{ asset('storage/' . $message->sender->image_path) }}" alt="{{ $message->sender->name }}"
                    class="rounded-circle" style="width: 50px; height: 50px;">
            </div>
        @endif
        <div class="message-content">
            <p>{{ $message->content }}</p>
            <p class="text-muted"><small>{{ $message->created_at->diffForHumans() }}</small></p>
        </div>
    </div>
@endforeach