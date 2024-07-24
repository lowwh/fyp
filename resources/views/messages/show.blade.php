@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">{{ $receiver->name }}</h1>

    <div class="message-container" id="message-container">
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
    </div>

    <div class="conversation mt-5">
        <form action="{{ route('messages.store') }}" method="POST" id="messageForm" class="d-flex align-items-center">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">

            <div class="form-group w-100 position-relative">
                <textarea name="content" id="content" class="form-control" rows="1" required></textarea>
                <button type="submit" class="btn btn-primary send-button" id="sendButton">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    .message-container {
        max-width: 1500px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

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
        background-color: #e9ecef;
        padding: 15px;
        border-radius: 15px;
        max-width: 70%;
    }

    .message.sent {
        justify-content: flex-end;
    }

    .message.sent .message-content {
        background-color: #d4edda;
        color: #155724;
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
        border: 2px solid #007bff;
        padding: 3px;
    }

    .form-group {
        position: relative;
    }

    .form-control {
        padding-right: 50px;
        border-radius: 30px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .send-button {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        font-size: 1.5em;
        color: #007bff;
        cursor: pointer;
    }

    .send-button:hover {
        color: #0056b3;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sendButton = document.getElementById('sendButton');
        const messageForm = document.getElementById('messageForm');
        const messageContainer = document.getElementById('message-container');

        messageForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(messageForm);

            sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            sendButton.disabled = true;

            fetch(messageForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update message container with new message
                        messageContainer.innerHTML = data.messages;
                        messageForm.reset();
                    }
                    sendButton.innerHTML = '<i class="fa fa-paper-plane"></i>';
                    sendButton.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    sendButton.innerHTML = '<i class="fa fa-paper-plane"></i>';
                    sendButton.disabled = false;
                });
        });
    });
</script>