@extends('layouts.app')

@section('content')
<div class="container" style="background-color: #f8f9fa;">
    <div class="row">
        <!-- Main Content -->
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
                <div class="rounded-lg bg-white shadow-sm p-4 mb-4">
                    <div class="bg-info rounded-lg p-3 mb-3 text-center">
                        <h3 class="text-2xl font-semibold">{{ $user->title }}</h3>
                    </div>
                    @if($user->userimage)
                        <div class="d-flex align-items-center mb-4">
                            <img src="{{ asset('storage/' . $user->userimage) }}" alt="User Image" class="rounded-circle"
                                style="width: 60px; height: 60px; margin-right: 15px;">
                            <div>
                                <h4 class="text-xl font-bold">{{ $user->name }}</h4>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#sendEmailModal">
                                    Send Email
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Email Modal -->
                    <div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="sendEmailModalLabel">Send Email to {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('send.email', $user->id) }}" method="POST" id="sendEmailForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="emailContent" class="form-label">Email Content:</label>
                                            <textarea name="emailContent" id="emailContent" rows="4" class="form-control"
                                                required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary" id="sendEmailButton">Send Email
                                            <span id="spinner" class="spinner-border spinner-border-sm"
                                                style="display: none;"></span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p style="font-size: 30px">Total Bids: {{ $user->bids->count() }}</p>
                    @if($user->serviceimage)
                        <div class="text-center mt-4">
                            <img src="{{ asset('storage/' . $user->serviceimage) }}" alt="Service Image"
                                style="max-width: 100%; height: auto;">
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Sidebar: About the Gig -->
        <div class="col-md-4 mt-3">
            <div class="card shadow-sm">
                <div class="card-header bg-info">
                    About this Gig
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="profileTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="bio-tab" data-bs-toggle="tab" href="#bio" role="tab"
                                aria-controls="bio" aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="about-tab" data-bs-toggle="tab" href="#about" role="tab"
                                aria-controls="about" aria-selected="false">About</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="profileTabContent">
                        <div class="tab-pane fade show active" id="bio" role="tabpanel" aria-labelledby="bio-tab">
                            <p>{{ $user->description }}</p>
                            <form
                                action="{{ route('payment', ['serviceOwnerId' => $user->userid, 'userid' => $user->id, 'serviceid' => $user->serviceid, 'freelancerid' => $user->freelancer_id, 'price' => $user->price]) }}"
                                method="get">
                                <button class="btn btn-success">Order</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                            <p><strong>From:</strong> {{ $user->state }}</p>
                            <p><strong>Join Since:</strong> {{ $user->user_created_date }}</p>
                            <p><strong>Language:</strong> {{ $user->language }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ratings Summary -->
    <div class="bg-white rounded-lg shadow-sm p-4 mt-4">
        <h4 class="text-2xl font-semibold text-center">Service Ratings Summary</h4>
        @if($comments->isNotEmpty())
                @php
                    $totalRatings = count($comments);
                    $ratingsCount = [
                        5 => $comments->where('rating', 5)->count(),
                        4 => $comments->where('rating', 4)->count(),
                        3 => $comments->where('rating', 3)->count(),
                        2 => $comments->where('rating', 2)->count(),
                        1 => $comments->where('rating', 1)->count(),
                    ];
                @endphp
                @foreach([5, 4, 3, 2, 1] as $rating)
                    <div class="mb-2">
                        <p><strong>{{ $rating }}-Star Ratings: {{ $ratingsCount[$rating] }}</strong></p>
                        <div class="rating-bar">
                            <div class="bar"
                                style="width: {{ ($totalRatings > 0) ? ($ratingsCount[$rating] / $totalRatings) * 100 : 0 }}%;">
                            </div>
                        </div>
                    </div>
                @endforeach
        @else
            <p class="text-center">No reviews yet</p>
        @endif
    </div>

    <!-- Service Reviews -->
    <div class="bg-white rounded-lg shadow-sm p-4 mt-4">
        <h4 class="text-2xl font-semibold text-center">Service Reviews</h4>
        @if($comments->isNotEmpty())
            @foreach($comments as $comment)
                <div class="border-bottom mb-3 pb-3">
                    @if($comment->image_path)
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ asset('storage/' . $comment->image_path) }}" alt="User Image" class="rounded-circle"
                                style="width: 50px; height: 50px; margin-right: 15px;">
                            <div>
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="fa fa-star {{ $i <= $comment->rating ? 'checked' : '' }}"></span>
                                @endfor
                            </div>
                        </div>
                    @endif
                    <p>{{ $comment->reason }}</p>
                </div>
            @endforeach
        @else
            <p class="text-center">No reviews yet</p>
        @endif
    </div>
</div>

<style>
    .user-info {
        display: flex;
        align-items: center;
    }

    .user-info button {
        margin-left: 15px;
    }

    .fa-star {
        color: #ccc;
    }

    .checked {
        color: #f39c12;
    }

    .rating-bar {
        height: 8px;
        background-color: #ddd;
        margin-bottom: 4px;
    }

    .bar {
        height: 100%;
        background-color: #28a745;
    }

    .spinner-border {
        margin-left: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusAlert = document.getElementById('statusAlert');
        if (statusAlert) {
            setTimeout(() => { statusAlert.style.display = 'none'; }, 3000);
        }

        const bidAlert = document.getElementById('bidAlert');
        if (bidAlert) {
            setTimeout(() => { bidAlert.style.display = 'none'; }, 3000);
        }

        const sendEmailForm = document.getElementById('sendEmailForm');
        if (sendEmailForm) {
            sendEmailForm.addEventListener('submit', function () {
                document.getElementById('spinner').style.display = 'inline-block';
                document.getElementById('sendEmailButton').setAttribute('disabled', true);
            });
        }
    });
</script>
@endsection