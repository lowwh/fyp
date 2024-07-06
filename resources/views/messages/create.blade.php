@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">Send Message to {{ $user->name }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $user->id }}">

                <div class="mb-3">
                    <label for="content" class="form-label">Message</label>
                    <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection