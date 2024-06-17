@extends('layouts.app')

@section('content')
<div class="container ml-8">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @foreach($users as $user)
        <div class="rounded-lg bg-gray-200 p-1 mb-1">
            <div class="bg-gray-300 rounded-lg p-2 mb-2" style="background-color:#f0f0f0;">
                <p class="text-lg font-semibold">{{ $user->title }}</p>
            </div>
            @if($user->userimage)
                <div class="user-info">
                    <img src="{{ asset('storage/' . $user->userimage) }}" alt="Service Image" class="rounded-circle"
                        style="width: 50px; height: 50px;">
                    <h1 class="text-xl font-bold">{{ $user->name }}</h1>
                    <form action="{{ route('send.email', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </form>
                </div>
            @endif
            <br>
            @if($user->image_path)
                <div>
                    <img src="{{ asset('storage/' . $user->serviceimage) }}" alt="Service Image"
                        style="max-width: 500px; height: auto;">
                </div>
            @endif


        </div>
    @endforeach
</div>
<style>
    .user-info {
        display: flex;
        align-items: center;
    }

    .user-info button {
        margin-left: 20px;
        /* Adjust the margin value as needed */
    }
</style>
@endsection