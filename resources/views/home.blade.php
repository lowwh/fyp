@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-20">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item active"><i class="fas fa-home nav-icon"></i> Home</li>
                    </ol>
                </div>
            </div>

            <h1>Freelancers List</h1>

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
                            <div class="card-body d-flex justify-content-between flex-column">
                                <div class="mb-3">
                                    @if($freelancer->serviceimage)
                                        <div class="service-image">
                                            <img src="{{ asset('storage/' . $freelancer->serviceimage) }}" alt="Service Image">
                                        </div>
                                    @endif
                                    <br>
                                    @if($freelancer->image_path)
                                        <div class="freelancer-image">
                                            <img src="{{ asset('storage/' . $freelancer->image_path) }}" alt="Freelancer Image">
                                        </div>
                                    @endif
                                    <div class="gig-info">




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
                                    </div>
                                </div>
                                <div class="price-info">
                                    <h5 class="card-title">From: RM</h5>
                                    <p>{{ $freelancer->price }}</p>
                                </div>
                                <a href="/viewprofile/{{ $freelancer->main_id }}"
                                    class="btn btn-primary mt-auto view-profile-button">View Profile</a>
                                <a href="/viewservice/{{ $freelancer->main_id }}/{{ $freelancer->serviceid }}"
                                    class="btn btn-secondary mt-auto view-service-button">View Service</a>
                                <a href="{{ route('messages.create', $freelancer->main_id) }}"
                                    class="btn btn-success mt-auto">Send Message</a>
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
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: .25rem;
    }

    .freelancer-card {
        width: 100%;
        background-color: white;
        padding: 5px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .service-image img {
        max-width: 300px;
        height: 300px;
    }

    .freelancer-image img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .gig-info .gig-detail {
        margin-bottom: 10px;
    }

    .gig-info h5 {
        display: inline;
        font-weight: bold;
        font-size: 1.2rem;
        margin-top: 5px
    }

    .gig-info p {
        display: inline;
        margin-left: 10px;
        font-size: 1.2rem;
    }

    .price-info {
        text-align: center;
        align-items: center;
        align-self: flex-end;
        background-color: #f0f8ff;
        padding: 5px;
        padding-top: 14px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        margin-bottom: 10px;
        width: 40%
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        margin: 6px;

    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        margin: 6px
    }

    .btn-success {
        margin: 6px
    }

    .btn:hover {
        opacity: 0.5;
    }
</style>
@endsection