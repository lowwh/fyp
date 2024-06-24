@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Message from {{ $message->sender->name }}</h1>
    <div class="card">
        <div class="card-body">
            <p class="card-text">{{ $message->content }}</p>
            <p class="card-text"><small class="text-muted">{{ $message->created_at->diffForHumans() }}</small></p>
        </div>
    </div>
    <a href="{{ route('receivedmessages') }}" class="btn btn-primary mt-3">Back to Messages</a>
</div>
@endsection