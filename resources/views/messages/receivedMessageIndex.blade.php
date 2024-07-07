@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Messages</h1>

    </div>

    <div class="bg-light p-3 my-4 rounded shadow-sm">
        <h2 class="text-center">Received Messages</h2>
    </div>

    @php
        // Group messages by sender_id and get the latest message for each sender
        $groupedMessages = $receivedMessages->groupBy('sender_id')->map(function ($messages) {
            return $messages->sortByDesc('created_at')->first();
        });
    @endphp

    @foreach($groupedMessages as $message)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">From: {{ $message->sender->name }}</h5>
                        <p class="card-text">{{ Str::limit($message->content, 50) }}</p>
                        <p class="card-text"><small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                        </p>
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
@endsection