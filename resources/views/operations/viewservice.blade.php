@extends('layouts.app')

@section('content')
<div class="container" style="background-color:#D3D3D3;">
    <div class="row">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @foreach($users as $user)
                <div class="rounded-lg bg-gray-200 p-3 mb-3">
                    <div class="bg-gray-300 rounded-lg p-3 mb-3" style="background-color: whitesmoke; text-align: center;">
                        <p class="text-xl font-bold">{{ $user->title }}</p>
                    </div>
                    @if($user->userimage)
                        <div class="user-info mb-3">
                            <img src="{{ asset('storage/' . $user->userimage) }}" alt="User Image" class="rounded-circle"
                                style="width: 50px; height: 50px; margin-right: 20px">
                            <h1 class="text-xl font-bold">{{ $user->name }}</h1>
                            <form action="{{ route('send.email', $user->id) }}" method="POST" id="sendEmailForm">
                                @csrf
                                <button type="submit" class="btn btn-primary" id="sendEmailButton">
                                    Send Email <span id="spinner" style="display: none;"></span>
                                </button>
                            </form>
                        </div>
                    @endif
                    @if($user->serviceimage)
                        <div>
                            <img src="{{ asset('storage/' . $user->serviceimage) }}" alt="Service Image"
                                style="max-width: 100%; height: auto; ; margin-top: 50px">
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="col-md-4">
            <div class="rounded-lg bg-gray-200 p-3 mb-3" style="border: 2px solid black;">
                <div class="bg-gray-300 rounded-lg p-3" style="background-color: whitesmoke;">
                    <p class="text-xl font-bold" style="text-align: center;">About this gig</p>
                </div>
                <div class="p-3">
                    <p>{{$user->description}}</p>
                </div>
                <div style="display: flex; justify-content: flex-end;">
                    <p style="background-color: #f0f8ff; padding: 5px; margin: 0;">{{$user['price']}}</p>
                </div>

            </div>
        </div>
    </div>
    <div class="bg-gray-300 rounded-lg p-3 mb-3"
        style="background-color: #f0f0f0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-top: 150px; width: 300px;">
        @foreach($users as $user)
            <div class="bg-gray-300 rounded-lg p-3 mb-3"
                style="background-color: white; text-align: left; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                <div>
                    <p style="margin: 0;">
                        From:
                        <span style="margin-left: 75px;">Join Since:</span>
                    </p>
                </div>
                <div>
                    <p style="margin: 0;">
                        <strong>{{$user['state']}}</strong>
                        <strong> <span style="margin-left: 45px;">{{$user['user_created_date']}}</span></strong>
                    </p>
                </div>
                <br><br>
                <!-- second line -->
                <div>
                    <p style="margin: 0;">
                        Language:

                    </p>
                </div>
                <div>
                    <p style="margin: 0;">
                        <strong>{{$user['language']}}</strong>

                    </p>
                </div>


            </div>




        @endforeach
    </div>
    <br><br>

    <!-- Displaying Ratings Summary -->
    <div class="bg-gray-300 rounded-lg p-3 mb-3"
        style="background-color: #f0f0f0; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-top: 20px;">
        <p class="text-xl font-bold">Service Ratings Summary</p>
        @if($comments->isNotEmpty())
                @php
                    // Calculate star ratings count
                    $totalRatings = count($comments);
                    $fiveStarCount = $comments->where('rating', 5)->count();
                    $fourStarCount = $comments->where('rating', 4)->count();
                    $threeStarCount = $comments->where('rating', 3)->count();
                    $twoStarCount = $comments->where('rating', 2)->count();
                    $oneStarCount = $comments->where('rating', 1)->count();
                @endphp

                <div class="bg-gray-300 rounded-lg p-3 mb-3"
                    style="background-color: white; text-align: left; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <p><strong>{{ $totalRatings }} reviews for this Gig </strong></p>
                    <p><strong>5-Star Ratings: {{ $fiveStarCount }}</strong></p>
                    <div class="rating-bar">
                        <div class="bar"
                            style="width: {{ ($totalRatings > 0) ? ($fiveStarCount / $totalRatings) * 100 : 0 }}%;">
                        </div>
                    </div>
                    <p><strong>4-Star Ratings: {{ $fourStarCount }}</strong> </p>
                    <div class="rating-bar">
                        <div class="bar"
                            style="width: {{ ($totalRatings > 0) ? ($fourStarCount / $totalRatings) * 100 : 0 }}%;">
                        </div>
                    </div>
                    <p><strong>3-Star Ratings: {{ $threeStarCount }}</strong></p>
                    <div class="rating-bar">
                        <div class="bar"
                            style="width: {{ ($totalRatings > 0) ? ($threeStarCount / $totalRatings) * 100 : 0 }}%;">
                        </div>
                    </div>
                    <p><strong>2-Star Ratings: {{ $twoStarCount }}</strong></p>
                    <div class="rating-bar">
                        <div class="bar" style="width: {{ ($totalRatings > 0) ? ($twoStarCount / $totalRatings) * 100 : 0 }}%;">
                        </div>
                    </div>
                    <p><strong>1-Star Ratings: {{ $oneStarCount }}</strong></p>
                    <div class="rating-bar">
                        <div class="bar" style="width: {{ ($totalRatings > 0) ? ($oneStarCount / $totalRatings) * 100 : 0 }}%;">
                        </div>
                    </div>
                </div>
        @else
            <div class="bg-gray-300 rounded-lg p-3 mb-3"
                style="background-color: white; text-align: left; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <p><strong>0 reviews for this Gig </strong></p>
                <p><strong>5-Star Ratings:</strong> 0</p>
                <div class="rating-bar">
                    <div class="bar" style="width: 0%;"></div>
                </div>
                <p><strong>4-Star Ratings:</strong> 0</p>
                <div class="rating-bar">
                    <div class="bar" style="width: 0%;"></div>
                </div>
                <p><strong>3-Star Ratings:</strong> 0</p>
                <div class="rating-bar">
                    <div class="bar" style="width: 0%;"></div>
                </div>
                <p><strong>2-Star Ratings:</strong> 0</p>
                <div class="rating-bar">
                    <div class="bar" style="width: 0%;"></div>
                </div>
                <p><strong>1-Star Ratings:</strong> 0</p>
                <div class="rating-bar">
                    <div class="bar" style="width: 0%;"></div>
                </div>
            </div>
        @endif
    </div>
    <!-- Displaying Service Review -->
    <div class="bg-gray-300 rounded-lg p-3 mb-3"
        style="background-color: #f0f0f0; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-top: 150px;">
        <p class="text-xl font-bold">Service Reviews</p>
        @if($comments->isNotEmpty())
            @foreach($comments as $comment)

                <div class="bg-gray-300 rounded-lg p-3 mb-3"
                    style="background-color: white; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    @if($comment->image_path)
                        <div class="user-info mb-3 d-flex align-items-center">
                            <img src="{{ asset('storage/' . $comment->image_path) }}" alt="User Image" class="rounded-circle"
                                style="width: 50px; height: 50px; margin-right: 20px; ">
                            <div>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $comment->rating)
                                        <span class="fa fa-star checked"></span>
                                    @else
                                        <span class="fa fa-star"></span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    @endif
                    <div style="text-align: left; margin-left: 10px;">
                        <p>{{$comment['reason']}}</p>
                    </div>
                </div>


            @endforeach
        @else
            <div class="bg-gray-300 rounded-lg p-3 mb-3"
                style=" background-color: white; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <p>No reviews yet</p>
            </div>
        @endif
    </div>

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

    .fa-star {
        color: #ccc;
        /* Default star color */
    }

    .checked {
        color: orange;
        /* Color for filled stars */
    }

    .rating-bar {
        height: 10px;
        background-color: #ddd;
        margin-bottom: 5px;
    }

    .bar {
        height: 100%;
        background-color: green;
        /* Adjust color as per your design */
    }

    #spinner {
        display: inline-block;
        width: 1em;
        height: 1em;
        vertical-align: text-bottom;
        border: .25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spin .75s linear infinite;
    }

    /* Keyframes for the spinner animation */
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('sendEmailForm').addEventListener('submit', function () {
            var spinner = document.getElementById('spinner');
            spinner.style.display = 'inline-block'; // Show the spinner

            // Optional: Disable the button to prevent multiple submissions
            document.getElementById('sendEmailButton').setAttribute('disabled', true);
        });
    });
</script>

@endsection