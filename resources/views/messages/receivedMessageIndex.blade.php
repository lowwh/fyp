@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Messages</h1>

    <div style="background-color:lightgrey; width:300px">
        <h2>Received Messages</h2>
    </div>

    @php
        // Group messages by sender_id and get the latest message for each sender
        $groupedMessages = $receivedMessages->groupBy('sender_id')->map(function ($messages) {
            return $messages->sortByDesc('created_at')->first();
        });
    @endphp

    @foreach($groupedMessages as $message)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">From: {{ $message->sender->name }}</h5>
                <p class="card-text">{{ Str::limit($message->content, 1) }}</p>
                <p class="card-text"><small class="text-muted">{{ $message->created_at->diffForHumans() }}</small></p>
                <a href="{{ route('messages.show', ['user' => $message->sender->id, 'message' => $message->id]) }}"
                    class="btn btn-primary">View Messages from
                    {{ $message->sender->name }}</a>

                <!-- <a href="{{ route('messages.create', $message->sender_id) }}" class="btn btn-primary">Reply</a> -->
            </div>
        </div>
    @endforeach
</div>@endsection