@extends('layouts.app')

@section('content')
<div class="container" style="background-color:#f8f9fa;">
    <div class="row">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-info" id="statusAlert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('bid'))
                <div class="alert alert-info" id="bidAlert">
                    {{ session('bid') }}
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
                            <!-- send email button -->
                            <form action="{{ route('send.email', $user->id) }}" method="POST" id="sendEmailForm">
                                @csrf
                                <button type="submit" class="btn btn-info" id="sendEmailButton">
                                    Send Email <span id="spinner" style="display: none;"></span>
                                </button>
                            </form>
                            <!-- Bid Button -->
                            <!-- <form
                                        action="{{ route('bid', ['userid' => $user->id, 'serviceid' => $user->serviceid, 'freelancerid' => $user->freelancer_id, 'serviceprice' => $user->price]) }}"
                                        method="POST" id="bidForm">
                                        @csrf
                                        <button type="submit" class="btn btn-info bid-button" data-user="{{$user->name}}">Bid</button>
                                    </form> -->
                        </div>
                    @endif





                    <!-- Displaying the number of bids -->
                    <p style="font-size: 30px">Total Bids: {{ $user->bids->count() }}</p>
                    @if($user->serviceimage)
                        <div>
                            <img src="{{ asset('storage/' . $user->serviceimage) }}" alt="Service Image"
                                style="width: 500px; height: 500px; ; margin-top: 50px">
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- About the gig -->
        <div class="col-md-4" style="margin-top: 10px; ">
            <div class="row justify-content-center">
                <div class="col-md-11"
                    style="box-shadow: 4px 4px 6px rgba(0.2, 0.2, 0.2, 0.2); background-color: white">
                    <div class="card mb-3" style="margin-top:20px">
                        <div class="card-header bg-light shadow-sm"
                            style="background-color:white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); ">
                            About this gig
                        </div>
                        <div class="card-body bg-light shadow-sm"
                            style="background-color:white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);">
                            <!-- Tabs for BIO -->
                            <ul class="nav nav-tabs" id="profileTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="bio-tab" data-bs-toggle="tab" href="#bio" role="tab"
                                        aria-controls="bio" aria-selected="true"
                                        style="background-color:white">Description</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="about-tab" data-bs-toggle="tab" href="#about" role="tab"
                                        aria-controls="about" aria-selected="false"
                                        style="background-color:white">About</a>
                                </li>

                            </ul>

                            <!-- Tab content -->

                            <div class="tab-content mt-3" id="profileTabContent">
                                <!-- BIO Tab -->

                                <div class="tab-pane fade show active" id="bio" role="tabpanel"
                                    aria-labelledby="bio-tab">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p id="name">{{ $user['description'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="continue-button">
                                                <form
                                                    action="{{ route('payment', ['userid' => $user->id, 'serviceid' => $user->serviceid, 'freelancerid' => $user->freelancer_id, 'price' => $user->price]) }}"
                                                    method="get">
                                                    <button class="btn btn-primary">Continue</button>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- end of bio tab -->

                                <!-- about tab  -->
                                <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            @foreach($users as $user)
                                                <div class="bg-gray-300 rounded-lg p-3 mb-3"
                                                    style="background-color: white; text-align: left; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                    <div
                                                        style="display: flex; justify-content: space-between; align-items: center;">
                                                        <p style="margin: 0;">
                                                            From: <br><strong>{{$user['state']}}</strong>
                                                        </p>
                                                        <p style="margin: 0;">
                                                            Join Since: <br>
                                                            <strong>{{$user['user_created_date']}}</strong>
                                                        </p>
                                                    </div>
                                                    <br><br>
                                                    <!-- second line -->
                                                    <div>
                                                        <p style="margin: 0;">
                                                            Language: <br>
                                                            <strong>{{$user['language']}}</strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- end of about tab -->






                            </div>
                            <!-- end of  tab content-->


                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <br><br><br><br><br><br>

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

    .alert-yellow {
        background-color: #ffc107;
        /* Yellow background color */
        color: #000000;
        /* Text color */
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: .25rem;
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

    document.addEventListener('DOMContentLoaded', function () {
        var bidForms = document.querySelectorAll('.bid-button');
        bidForms.forEach(function (form) {
            form.addEventListener('click', function (event) {
                event.preventDefault();
                var userName = this.getAttribute('data-user');
                var confirmBid = confirm('Are you sure you want to bid on ' + userName + '\'s service?');
                if (confirmBid) {
                    document.getElementById('bidForm').submit();
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var statusAlert = document.getElementById('statusAlert');
        if (statusAlert) {

            setTimeout(function () {
                statusAlert.style.display = 'none';
            }, 5000);
        }

        var bidAlert = document.getElementById('bidAlert');
        if (bidAlert) {

            setTimeout(function () {
                bidAlert.style.display = 'none';
            }, 5000);
        }
    });
</script>

@endsection