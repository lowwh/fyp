@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Total Price Section -->
            @can('isFreelancer')
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="total-box bg-light rounded-lg p-4 shadow">

                            <h4 class="mb-2 text-primary">Total Earnings</h4>
                            <p class="display-4 font-weight-bold mb-0">RM {{ number_format($earn, 2) }}</p>

                        </div>
                    </div>
                </div>
            @endcan
            @can('isUser')
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="total-box bg-light rounded-lg p-4 shadow">

                            <h4 class="mb-2 text-primary">Total Spending</h4>
                            <p class="display-4 font-weight-bold mb-0">RM {{ number_format($totalPrice, 2) }}</p>

                        </div>
                    </div>
                </div>
            @endcan
            <!-- History List -->
            @can('isUser')
                <div class="row">
                    @if($results->isNotEmpty())
                        @foreach($results as $result)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="service-card card shadow-lg border-0 rounded">
                                    @if($result->image_path)
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $result->image_path) }}" alt="Service Image"
                                                class="card-img-top"
                                                style="object-fit: cover; height: 180px; border-bottom: 1px solid #e0e0e0;">
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        @if($result->userimage)
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="{{ asset('storage/' . $result->userimage) }}" alt="User Image"
                                                    class="rounded-circle"
                                                    style="width: 60px; height: 60px; border: 2px solid #007bff;">
                                                <h5 class="card-title ml-3">{{ $result->username }}</h5>
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
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <p class="price mb-0"><strong>Price:</strong> RM {{ number_format($result->price, 2) }}</p>
                                        <!-- <a href="{{ url('/service/' . $result->gig_id) }}"
                                                                                                                                                    class="btn btn-outline-primary btn-sm">View Details</a> -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-history bg-light rounded-lg p-5 mb-5 text-center shadow"
                            style="max-width: 600px; margin: 0 auto;">
                            <p class="display-4 font-weight-bold mb-4">No History Yet</p>
                            <p class="lead">You haven't completed any services yet. Start browsing and complete your first
                                service today!</p>
                            <a href="{{ url('/searchresult') }}" class="btn btn-primary mt-3">Browse Services</a>
                        </div>
                    @endif
                </div>
            @endcan
            <!-- End User History List -->
            <!--Freelancer History List -->
            @can('isFreelancer')
                <div class="row">
                    @if($freelancerresult->isNotEmpty())
                        @foreach($freelancerresult as $result)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="service-card card shadow-lg border-0 rounded">
                                    @if($result->image_path)
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $result->image_path) }}" alt="Service Image"
                                                class="card-img-top"
                                                style="object-fit: cover; height: 180px; border-bottom: 1px solid #e0e0e0;">
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        @if($result->userimage)
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="{{ asset('storage/' . $result->userimage) }}" alt="User Image"
                                                    class="rounded-circle"
                                                    style="width: 60px; height: 60px; border: 2px solid #007bff;">
                                                <h5 class="card-title ml-3">{{ $result->username }}</h5>
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
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <p class="price mb-0"><strong>Price:</strong> RM {{ number_format($result->price, 2) }}</p>
                                        <!-- <a href="{{ url('/service/' . $result->gig_id) }}"
                                                                                                                                                                            class="btn btn-outline-primary btn-sm">View Details</a> -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-history bg-light rounded-lg p-5 mb-5 text-center shadow"
                            style="max-width: 600px; margin: 0 auto;">
                            <p class="display-4 font-weight-bold mb-4">No History Yet</p>
                            <p class="lead">You haven't completed any services yet. Start browsing and complete your first
                                service today!</p>
                            <a href="{{ url('/searchresult') }}" class="btn btn-primary mt-3">Browse Services</a>
                        </div>
                    @endif
                </div>
            @endcan
        </div>
        <!-- end freelancer history -->
    </div>
</div>

@section('scripts')
<script src="{{ mix('/js/app.js') }}"></script>
@endsection

<style>
    .total-box {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .display-4 {
        font-size: 2.5rem;
        color: #007bff;
    }

    .font-weight-bold {
        font-weight: 700;
    }

    .service-card {
        border-radius: 12px;
        overflow: hidden;
        background-color: #fff;
        transition: box-shadow 0.3s ease;
    }

    .service-card:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .card-img-top {
        border-bottom: 1px solid #e0e0e0;
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-weight: 600;
        font-size: 1.25rem;
    }

    .fa-star {
        color: #ddd;
    }

    .checked {
        color: #f39c12;
    }

    .fa-check-circle {
        color: #28a745;
    }

    .text-success {
        color: #28a745;
    }

    .price {
        font-size: 1.1rem;
        color: #333;
    }

    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
        font-weight: 500;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }

    .no-history {
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .display-4 {
        font-size: 2rem;
    }

    .font-weight-bold {
        font-weight: 700;
    }

    .lead {
        font-size: 1.25rem;
        font-weight: 300;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .total-box {
            padding: 1rem;
        }

        .display-4 {
            font-size: 1.75rem;
        }
    }
</style>
@endsection