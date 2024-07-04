@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Conversation with {{ $receiver->name }}</h1>

    @foreach($messages as $message)
        <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
            @if($message->sender_id != Auth::id())
                <div class="message-avatar">
                    <img src="{{ asset('storage/' . $message->sender->image_path) }}" alt="{{ $message->sender->name }}"
                        class="rounded-circle" style="width: 40px; height: 40px;">
                </div>
            @endif
            <div class="message-content">
                <p>{{ $message->content }}</p>
                <p class="text-muted">{{ $message->created_at->diffForHumans() }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection

<style>
    .message {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .message-avatar {
        margin-right: 10px;
        flex-shrink: 0;
    }

    .message-content {
        background-color: #f2f2f2;
        padding: 10px;
        border-radius: 10px;
        max-width: 70%;
    }

    .message.sent {
        justify-content: flex-end;
    }

    .message.sent .message-content {
        background-color: #dcf8c6;
    }

    .message.received .message-content {
        background-color: #f2f2f2;
    }

    .message p {
        margin: 0;
    }

    .message-content p.text-muted {
        font-size: 0.8rem;
    }

    .message-avatar img {
        border-radius: 50%;
    }
</style>