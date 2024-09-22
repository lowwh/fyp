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
                <!-- Column for Most Popular Freelancers -->
                <div class="col-md-3 mb-4">
                    <div class="card popular-freelancers-card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Most Popular Freelancers</h4>
                            @foreach($userCount as $popularFreelancer)
                                <div class="popular-freelancer-item mb-3" data-toggle="tooltip" data-placement="top"
                                    title="Name: {{ $popularFreelancer->name }}">
                                    <div class="text-center">
                                        @if($popularFreelancer->image_path)
                                            <img src="{{ asset('storage/' . $popularFreelancer->image_path) }}"
                                                alt="Freelancer Image" class="img-fluid rounded-circle"
                                                style="width: 60px; height: 60px;">
                                        @else
                                            <img src="{{ asset('images/noimage.jfif') }}" alt="No Image"
                                                class="img-fluid rounded-circle" style="width: 60px; height: 60px;">
                                        @endif
                                    </div>
                                    <div class="text-center mt-2">
                                        <p class="mb-1"><strong>{{ $popularFreelancer->title }}</strong></p>
                                        <div class="total-order">
                                            <p class="mb-1">Total Orders Placed: {{ $popularFreelancer->bids->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Column for Main Freelancers List -->
                <div class="col-md-9 mb-4">
                    <div class="row">
                        @foreach($freelancers as $freelancer)
                                                <div class="col-md-4 mb-4">
                                                    <div class="card freelancer-card">
                                                        <div class="card-body d-flex flex-column">
                                                            <div class="service-image-container">
                                                                @if($freelancer->serviceimage)
                                                                    <div class="service-image">
                                                                        <img src="{{ asset('storage/' . $freelancer->serviceimage) }}"
                                                                            alt="Service Image" class="img-fluid rounded">
                                                                    </div>
                                                                @else
                                                                    <div class="service-image">
                                                                        <img src="{{ asset('images/noimage.jfif') }}" alt="No Image"
                                                                            class="card-img">
                                                                    </div>
                                                                @endif
                                                                @if($freelancer->image_path)
                                                                    <div class="freelancer-image">
                                                                        <img src="{{ asset('storage/' . $freelancer->image_path) }}"
                                                                            alt="Freelancer Image" class="rounded-circle">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="gig-info text-center mt-3">
                                                                <h5 class="card-title mb-0">Service Title:</h5>
                                                                <p class="service-title">{{ $freelancer->title }}</p>
                                                                <h5 class="card-title mb-0">State:</h5>
                                                                <p>{{ $freelancer->state }}</p>
                                                                <h5 class="card-title mb-0">Posted On:</h5>
                                                                <p>{{ $freelancer->service_created_date }}</p>
                                                            </div>
                                                            <div class="rating text-center mt-3">
                                                                @php
    $averageRating = $ratings->get($freelancer->serviceid)->average_rating ?? 0;
    $starCount = round($averageRating);
                                                                @endphp
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <span class="fa fa-star {{ $i <= $starCount ? 'checked' : '' }}"></span>
                                                                @endfor
                                                                <span>{{ $ratings->get($freelancer->serviceid) ? $ratings->get($freelancer->serviceid)->count() : 0 }}
                                                                    reviews</span>
                                                            </div>
                                                            <div class="price-info text-center mt-3">
                                                                <h5 class="card-title">From: RM{{ $freelancer->price }}</h5>
                                                            </div>
                                                            <div class="mt-auto d-flex justify-content-around button-class">
                                                                <a href="/viewprofile/{{ $freelancer->main_id }}" class="btn btn-primary">View
                                                                    Profile</a>
                                                                <a href="/viewservice/{{ $freelancer->main_id }}/{{ $freelancer->serviceid }}"
                                                                    class="btn btn-secondary">View Service</a>
                                                                <a href="{{ route('messages.create', $freelancer->main_id, $freelancer->image_path) }}"
                                                                    class="btn btn-success">Send Message</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                {{ $freelancers->links() }}
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<style>
    .service-title {
        max-height: 60px;
        line-height: 20px;
        overflow: hidden;
        text-align: center;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gig-info {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .button-class {
        display: grid;
        grid-auto-flow: column;
        grid-gap: 10px;
        margin-left: -10px;
    }

    .card-title {
        margin-bottom: 10px;
        font-weight: bold; 
    }

    .rating .fa-star {
        color: #ddd;
        font-size: 1.2em;
    }

    .rating .fa-star.checked {
        color: #ffd700;
    }

    .freelancer-card {
        border: 1px solid #ddd;
        border-radius: .5rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: visible;
    }

    .service-image-container {
        position: relative;
        margin-bottom: 20px;
    }

    .service-image img {
        border-radius: .5rem;
        height: 150px;
        object-fit: cover;
        width: 100%;
    }

    .freelancer-image {
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
    }

    .freelancer-image img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.7);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .popular-freelancers-card {
        border: 1px solid #ddd;
        border-radius: .5rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
	
	  .gig-detail {
        margin-top: 20px
            /* Optional: Centers the text */
    }


    .total-order {
        font-weight: 100;
    }

    .button-class {
        display: grid;
        grid-auto-flow: column;
        grid-gap: 10px;
        /* Allows buttons to wrap on smaller screens */
        margin-left: -10px;
        /* Adjust this value to shift the buttons left */
    }


    .title-text {
        font-weight: 700;
        margin-bottom: 20px;
    }

    .card-title {
        margin-bottom: 20px;
    }

    .card-body
    .card-body {
        max-width: 2000px;
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

    .card-img {
        border-radius: .5rem;
    }

    .rating .fa-star {
        color: #ddd;
        font-size: 1.2em;
    }

    .rating .fa-star.checked {
        color: #ffd700;
    }

    .freelancer-card {
        border: 1px solid #ddd;
        border-radius: .5rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: visible;
        max-width: 2000px;

    }
</style>

@endsection