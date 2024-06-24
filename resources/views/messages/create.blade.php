@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Send Message to {{ $user->name }}</h1>
    <form action="{{ route('messages.store') }}" method="POST">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">

        <div class="form-group">
            <label for="content">Message</label>
            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>
@endsection