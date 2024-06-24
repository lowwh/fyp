@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Messages</h1>

    <div style="background-color:lightgrey; width:300px">
        <h2>Send Messages</h2>
    </div>

    @php
        // Group messages by sender_id and get the latest message for each sender
        $groupedMessages = $sentMessages->groupBy('receiver_id')->map(function ($messages) {
            return $messages->sortByDesc('created_at')->first();
        });
    @endphp

    @foreach($groupedMessages as $message)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">To: {{ $message->receiver->name }}</h5>
                <p class="card-text">{{ Str::limit($message->content, 100) }}</p>
                <p class="card-text"><small class="text-muted">{{ $message->created_at->diffForHumans() }}</small></p>
                <a href="{{ route('messages.show', $message->receiver) }}" class="btn btn-primary">View Messages from
                    {{ $message->receiver->name }}</a>
            </div>
        </div>
    @endforeach
</div>
@endsection