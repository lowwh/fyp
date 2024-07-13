@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item active"><i class="fas fa-home nav-icon"></i> Home</li>
                    </ol>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>

            <h1 class="display-4 text-center">Freelancers List</h1>

            <!-- Sort Dropdown -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <form method="GET" action="{{ route('home') }}">
                        <div class="input-group">
                            <select name="state" class="form-control" onchange="this.form.submit()">
                                <option value="">All States</option>
                                @foreach($states as $state)
                                    <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>
                                        {{ $state }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                @foreach($freelancers as $freelancer)
                                                                                                                <div class="col-md-4 mb-4">
                                                                                                                    <div class="card freelancer-card">
                                                                                                                        <div class="card-body d-flex flex-column">
                                                                                                                            <div class="text-center mb-3">
                                                                                                                                @if($freelancer->serviceimage)
                                                                                                                                    <div class="service-image">
                                                                                                                                        <img src="{{ asset('storage/' . $freelancer->serviceimage) }}" alt="Service Image"
                                                                                                                                            class="img-fluid rounded">
                                                                                                                                    </div>
                                                                                                                                    @else
                                                                                                                                        <div class="service-image">
                                                                                                                                            <img src="{{ asset('images/noimage.jfif') }}" alt="Painting Service Back" class="card-img">
                                                                                                                                        </div>
                                                                                                                                    @endif
                                                                                                                                <br>
                                                                                                                                @if($freelancer->image_path)
                                                                                                                                    <div class="freelancer-image mx-auto">
                                                                                                                                        <img src="{{ asset('storage/' . $freelancer->image_path) }}" alt="Freelancer Image"
                                                                                                                                            class="rounded-circle">
                                                                                                                                    </div>



                                                                                                                                @endif
                                                                                                                            </div>
                                                                                                                            <div class="gig-info text-center">
                                                                                                                                <div class="gig-detail">
                                                                                                                                    <h5 class="card-title mb-0">Gig ID:</h5>
                                                                                                                                    <p>{{ $freelancer->serviceid }}</p>
                                                                                                                                </div>
                                                                                                                                <div class="gig-detail">
                                                                                                                                    <h5 class="card-title mb-0">Gig Title:</h5>
                                                                                                                                    <p>{{ $freelancer->title }}</p>
                                                                                                                                </div>
                                                                                                                                <div class="gig-detail">
                                                                                                                                    <h5 class="card-title mb-0">State:</h5>
                                                                                                                                    <p>{{ $freelancer->state }}</p>
                                                                                                                                </div>
                                                                                                                                <div class="gig-detail">
                                                                                                                                    <h5 class="card-title mb-0">Posted On:</h5>
                                                                                                                                    <p>{{ $freelancer->service_created_date }}</p>
                                                                                                                                </div>

                                                                                                                            </div>

                                                                                                                            <div class="rating text-center mt-3">
                                                                                                                                @php
    $serviceRatings = $ratings->where('gig_id', $freelancer->serviceid);
    $ratingCount = $serviceRatings->count();
                                                                                                                                @endphp
                                                                                                                                <span class="fa fa-star checked"></span>
                                                                                                                                <span class="fa fa-star checked"></span>
                                                                                                                                <span class="fa fa-star checked"></span>
                                                                                                                                <span class="fa fa-star"></span>
                                                                                                                                <span class="fa fa-star"></span>
                                                                                                                                <span>{{ $ratingCount }} reviews</span>
                                                                                                                            </div>


                                                                                                                            <div class="price-info text-center mt-3">
                                                                                                                                <h5 class="card-title">From: RM{{ $freelancer->price }}</h5>
                                                                                                                            </div>
                                                                                                                            <div class="mt-auto d-flex justify-content-around">
                                                                                                                                <a href="/viewprofile/{{ $freelancer->main_id }}"
                                                                                                                                    class="btn btn-primary view-profile-button">View Profile</a>
                                                                                                                                <a href="/viewservice/{{ $freelancer->main_id }}/{{ $freelancer->serviceid }}"
                                                                                                                                    class="btn btn-secondary view-service-button">View Service</a>
                                                                                                                                <a href="{{ route('messages.create', $freelancer->main_id) }}"
                                                                                                                                    class="btn btn-success">Send Message</a>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {{ $freelancers->links() }}
            </div>
        </div>
    </div>
</div>

<script src="{{ mix('/js/app.js') }}"></script>

<style>
    .breadcrumb {
        background-color: #f8f9fa;
        border-radius: .25rem;
    }

    .card {
        border: none;
        border-radius: .75rem;
        overflow: hidden;
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .freelancer-card {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease-in-out;
    }

    .freelancer-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .service-image img {
        width: 100%;
        height: 300px;
        border-radius: 10px;
    }
    

    .freelancer-image img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-top: -40px;
        border: 3px solid white;
    }

    .gig-info .gig-detail {
        margin-bottom: 10px;
    }

    .gig-info h5 {
        display: inline;
        font-weight: bold;
        font-size: 1rem;
        color: #333;
    }

    .gig-info p {
        display: inline;
        margin-left: 5px;
        font-size: 1rem;
        color: #666;
    }

    .rating .fa-star {
        color: #ffd700;
    }

    .rating span {
        font-size: 0.9rem;
        color: #666;
    }

    .price-info {
        font-size: 1.2rem;
        color: #333;
        font-weight: bold;
        margin-top: 10px;
        background-color: #f0f8ff;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-primary,
    .btn-secondary,
    .btn-success {
        margin: 6px;
        width: 100%;
        transition: opacity 0.3s;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn:hover {
        opacity: 0.8;
    }
</style>
@endsection