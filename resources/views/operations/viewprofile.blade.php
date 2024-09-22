@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Navbar with user's name in the upper right -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm rounded">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Profile</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">{{ $user->first()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link"><i class="fas fa-check-circle text-success"></i> 100% job complete</span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link"><i class="fas fa-clock text-success"></i> 100% on time</span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Central content with tabs -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-white border-bottom-0">
                    <h4 class="mb-0">Profile Details</h4>
                </div>
                <div class="card-body">
                    <!-- Tabs for BIO, Service, and Review -->
                    <ul class="nav nav-tabs" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="bio-tab" data-bs-toggle="tab" href="#bio" role="tab"
                                aria-controls="bio" aria-selected="true">BIO</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="project-tab" data-bs-toggle="tab" href="#project" role="tab"
                                aria-controls="project" aria-selected="false">Services</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="review-tab" data-bs-toggle="tab" href="#review" role="tab"
                                aria-controls="review" aria-selected="false">Reviews</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-3" id="profileTabContent">
                        <!-- BIO Tab -->
                        <div class="tab-pane fade show active" id="bio" role="tabpanel" aria-labelledby="bio-tab">

                            <div class="row mb-3">
                                <label for="freelancerid" class="col-md-4 col-form-label text-md-end">
                                    <i class="fas fa-id-badge"></i> Freelancer ID:
                                </label>
                                <div class="col-md-6">
                                    <p id="freelancerid" class="form-control-plaintext">
                                        {{ $user->first()->freelancer_id }}
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">
                                    <i class="fas fa-user"></i> Freelancer Name:
                                </label>
                                <div class="col-md-6">
                                    <p id="name" class="form-control-plaintext">{{ $user->first()->name }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="age" class="col-md-4 col-form-label text-md-end">
                                    <i class="fas fa-birthday-cake"></i> Age:
                                </label>
                                <div class="col-md-6">
                                    <p id="age" class="form-control-plaintext">{{ $user->first()->age }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="gender" class="col-md-4 col-form-label text-md-end">
                                    <i class="fas fa-venus-mars"></i> Gender:
                                </label>
                                <div class="col-md-6">
                                    <p id="gender" class="form-control-plaintext">{{ $user->first()->gender }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">
                                    <i class="fas fa-envelope"></i> Email:
                                </label>
                                <div class="col-md-6">
                                    <p id="email" class="form-control-plaintext">{{ $user->first()->email }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="state" class="col-md-4 col-form-label text-md-end">
                                    <i class="fas fa-map-marker-alt"></i> State:
                                </label>
                                <div class="col-md-6">
                                    <p id="state" class="form-control-plaintext">{{ $user->first()->state }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="language" class="col-md-4 col-form-label text-md-end">
                                    <i class="fas fa-language"></i> Language:
                                </label>
                                <div class="col-md-6">
                                    <p id="language" class="form-control-plaintext">{{ $user->first()->language }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Services Tab -->
                        <div class="tab-pane fade" id="project" role="tabpanel" aria-labelledby="project-tab">
                            <h5 class="mt-3">Services</h5>
                            <div class="row">
                                @foreach ($user as $record)
                                    @if ($record->service_id)
                                        <div class="col-md-6 mb-4">
                                            <div class="card service-card shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title text-primary">{{ $record->title }}</h5>
                                                    <br>
                                                    <p class="card-text"><strong>Description:</strong>
                                                        {{ $record->description }}</p>

                                                    </p>
                                                    <p class="card-text"><strong>Service Type:</strong>
                                                        {{ $record->servicetype }}</p>

                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                            <h5 class="mt-3">Reviews</h5>
                            <div class="row">
                                @foreach ($ratings as $review)
                                    <div class="col-md-6 mb-4">
                                        <div class="card review-card shadow-sm">
                                            <div class="card-body">
                                                <blockquote class="blockquote mb-0">
                                                    <p class="mb-1">{{ $review->suggestion }}</p>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<!-- Custom CSS for Fiverr-like design -->
<style>
    .navbar-brand {
        font-size: 1.75rem;
        font-weight: bold;
        color: #ff5733;
    }

    .navbar-toggler {
        border-color: #ff5733;
    }

    .navbar-toggler-icon {
        color: #ff5733;
    }

    .card {
        border: none;
        border-radius: 10px;
    }

    .card-header {
        background-color: #ff5733;
        color: white;
        border-radius: 10px 10px 0 0;
    }

    .nav-tabs .nav-link.active {
        background-color: #ff5733;
        color: white;
        border: none;
        border-radius: 10px 10px 0 0;
    }

    .nav-tabs .nav-link {
        color: #ff5733;
    }

    .list-group-item {
        border: none;
        border-bottom: 1px solid #ddd;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .list-group-item strong {
        color: #ff5733;
    }

    .list-group-item .fas.fa-star {
        color: #ffcc00;
    }

    .service-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        transition: transform 0.2s;
    }

    .service-card:hover {
        transform: translateY(-5px);
    }

    .service-card .card-title {
        font-weight: bold;
        color: #ff5733;
    }

    .service-card .card-text {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .service-card .btn-primary {
        background-color: #ff5733;
        border-color: #ff5733;
    }

    .service-card .btn-primary:hover {
        background-color: #ff4500;
        border-color: #ff4500;
    }

    .card-body p {
        font-size: 1rem;
        line-height: 1.5;
        color: #555;
    }

    .card-body .btn-primary {
        background-color: #ff5733;
        border-color: #ff5733;
        color: #fff;
        font-weight: bold;
    }

    .review-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
        transition: transform 0.2s;
    }

    .review-card:hover {
        transform: translateY(-5px);
    }

    .review-card .card-body {
        padding: 1.25rem;
    }

    .review-card blockquote {
        border-left: 4px solid #ff5733;
        padding-left: 1rem;
        margin: 0;
        color: #555;
        font-size: 1.1rem;
    }

    .review-card blockquote p {
        margin-bottom: 0;
    }

    .card-body p {
        font-size: 1rem;
        line-height: 1.5;
    }
</style>

<!-- Custom JavaScript for animation -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('#navbarNav');

        navbarToggler.addEventListener('click', function () {
            navbarCollapse.classList.toggle('show');
        });

        const bioTab = document.querySelector('#bio-tab');
        const projectTab = document.querySelector('#project-tab');
        const reviewTab = document.querySelector('#review-tab');

        const animateTab = (tab) => {
            tab.classList.add('animate__animated', 'animate__bounceIn');
            tab.addEventListener('animationend', () => {
                tab.classList.remove('animate__animated', 'animate__bounceIn');
            });
        };

        bioTab.addEventListener('click', () => animateTab(bioTab));
        projectTab.addEventListener('click', () => animateTab(projectTab));
        reviewTab.addEventListener('click', () => animateTab(reviewTab));
    });
</script>

<!-- Add animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection