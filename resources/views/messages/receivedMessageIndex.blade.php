@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-4">Messages</h1>
    </div>

    <!-- <div class="bg-light p-4 my-4 rounded shadow-sm">
        <h2 class="text-center">Received Messages</h2>
    </div> -->

    @php
        // Group messages by sender_id and get the latest message for each sender
        $groupedMessages = $receivedMessages->groupBy('sender_id')->map(function ($messages) {
            return $messages->sortByDesc('created_at')->first();
        });
    @endphp

    @foreach($groupedMessages as $message)
        <div class="card mb-3 shadow-sm message-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="message-avatar">
                            <img src="{{ asset('storage/' . $message->sender->image_path) }}"
                                alt="{{ $message->sender->name }}" class="rounded-circle"
                                style="width: 50px; height: 50px;">
                        </div>
                        <div class="ml-3">
                            <h5 class="card-title mb-0">{{ $message->sender->name }}</h5>
                            <p class="card-text text-muted mb-0"><small>{{ $message->created_at->diffForHumans() }}</small>
                            </p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('messages.show', ['user' => $message->sender->id, 'message' => $message->id]) }}"
                            class="btn btn-primary">
                            <i class="fas fa-envelope-open-text"></i> View Messages
                        </a>
                    </div>
                </div>

            </div>
        </div>
    @endforeach

    @if($groupedMessages->isEmpty())
        <div class="alert alert-info" role="alert">
            You have no received messages.
        </div>
    @endif
</div>

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .display-4 {
        font-weight: bold;
        color: #333;
    }

    .message-card {
        border: none;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .message-card:hover {
        transform: translateY(-5px);
    }

    .message-avatar img {
        border: 2px solid #007bff;
        padding: 3px;
    }

    .message-avatar {
        margin-right: 15px;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #007bff;
    }

    .card-text {
        color: #555;
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

    .alert-info {
        background-color: #e9f7fd;
        border-color: #b3e5fc;
        color: #31708f;
    }

    .rounded {
        border-radius: 10px !important;
    }

    .shadow-sm {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endsection