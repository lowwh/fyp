@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="container">

            <!-- List Format -->
            <div class="row">
                @if($results->isNotEmpty())
                    @foreach($results as $result)
                        <div class="col-md-4 mb-4">
                            <div class="list-item card h-100 shadow-sm border-0 rounded">
                                <div class="card-body">
                                    @if($result->image_path)
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('storage/' . $result->image_path) }}" alt="Service Image"
                                                class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                                        </div>
                                    @endif
                                    @if($result->userimage)
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('storage/' . $result->userimage) }}" alt="User Image"
                                                class="rounded-circle" style="width: 50px; height: 50px;">
                                            <h5 class="card-title mt-2">{{ $result->username }}</h5>
                                        </div>
                                    @endif

                                    <p><strong>Gig ID:</strong> {{ $result->gig_id }}</p>

                                    <!-- Display Rating as Stars -->
                                    <p><strong>Rating:</strong>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $result->rating)
                                                <span class="fa fa-star checked"></span>
                                            @else
                                                <span class="fa fa-star"></span>
                                            @endif
                                        @endfor
                                    </p>
                                    <p>{{ $result->reason }}</p>

                                    <!-- Display Green Tick for Completed Task -->
                                    <p><i class="fa fa-check-circle text-success"></i> Completed</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white rounded-lg p-5 mb-5 text-center shadow" style="max-width: 600px; margin: 0 auto;">
                        <p style="font-size: 32px; font-weight: bold;">No History Service yet</p>
                    </div>
                @endif
            </div>
            <!-- End List Format -->

        </div>
    </div>
</div>

<script src="{{ mix('/js/app.js') }}"></script>
<style>
    .fa-star {
        color: #ccc;
        /* Default star color */
    }

    .checked {
        color: orange;
        /* Color for filled stars */
    }

    .fa-check-circle {
        color: green;
        /* Color for green tick */
    }

    .text-success {
        color: green;
        /* Bootstrap class for green text */
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .card-body {
        padding: 1.25rem;
    }

    .card-title {
        font-weight: bold;
        font-size: 1.25rem;
    }

    .card-text {
        font-size: 1rem;
    }

    .img-fluid {
        border-radius: 10px;
    }

    .shadow-sm {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .rounded {
        border-radius: 10px;
    }

    .rounded-circle {
        border-radius: 50%;
    }

    .text-center {
        text-align: center;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    .p-5 {
        padding: 3rem;
    }

    .shadow {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .bg-white {
        background-color: #fff;
    }
</style>
@endsection