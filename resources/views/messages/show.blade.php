@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center heading">{{ $receiver->name }}</h1>

    <div class="message-container" id="message-container">
        @foreach($messages as $message)
            <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }} mb-4">
                @if($message->sender_id != Auth::id())
                    <div class="message-avatar">
                        <img src="{{ asset('storage/' . $message->sender->image_path) }}" alt="{{ $message->sender->name }}"
                            class="rounded-circle" style="width: 50px; height: 50px;">
                        <div class="tooltip">
                            <strong>{{ $message->sender->name }}</strong><br>
                            {{ $message->sender->email }}<br>
                            {{ $message->sender->phone_number }} <!-- or any other relevant info -->
                        </div>
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
                <textarea name="content" id="content" class="form-control" rows="1" placeholder="Type your message..."
                    required></textarea>
                <button type="submit" class="btn btn-primary send-button" id="sendButton">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    /* Add these styles to your CSS file or within a <style> tag */
    .heading {
        font-size: 2.5rem;
        font-weight: bold;
        color: #333;
        text-transform: uppercase;
        transition: color 0.3s, transform 0.3s;

    }

    .heading::before {
        content: '🎉';
        /* Emoji or icon */
        position: 1px;

        /* Position the icon */
        top: 50%;
        transform: translateY(-50%);
        font-size: 2rem;
        /* Icon size */
    }

    .heading:hover {
        color: #007bff;
        /* Change color on hover */
        transform: scale(1.05);
        /* Slightly enlarge text */
    }


    .container {
        max-width: 4000px;
    }

    .message-container {
        max-width: 3500px;
        margin: 0 auto;
        padding: 20px;
        background: #f5f5f5;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        height: 1000px;
        /* Adjust height as needed */
    }

    .message {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .message-avatar {
        position: relative;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .message-avatar img {
        border-radius: 50%;
        border: 2px solid #007bff;
        padding: 3px;
        transition: border-color 0.3s ease;
    }

    .message-avatar img:hover {
        border-color: #0056b3;
    }

    .tooltip {
        display: none;
        /* Hidden by default */
        position: absolute;
        top: 60px;
        /* Adjust if needed */
        left: 50%;
        transform: translateX(-50%);
        background-color: #333;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        white-space: nowrap;
        font-size: 0.9rem;
        z-index: 1000;
        /* Ensure it appears above other content */
        width: max-content;
        max-width: 200px;
        /* Adjust if needed */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .message-avatar:hover .tooltip {
        display: block;
    }

    .message-content {
        background: #ffffff;
        padding: 15px;
        border-radius: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        max-width: 75%;
    }

    .message.sent {
        justify-content: flex-end;
    }

    .message.sent .message-content {
        background: #d4edda;
        color: #155724;
    }

    .message.received .message-content {
        background: #ffffff;
        color: #000000;
    }

    .message-content p {
        margin: 0;
    }

    .message-content p.text-muted {
        font-size: 0.8rem;
    }

    .form-group {
        position: relative;
    }

    .form-control {
        padding-right: 60px;
        border-radius: 30px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        resize: none;
        font-size: 1rem;
    }

    .send-button {
        position: absolute;
        right: 15px;
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
                        messageContainer.scrollTop = messageContainer.scrollHeight; // Auto-scroll to the bottom
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