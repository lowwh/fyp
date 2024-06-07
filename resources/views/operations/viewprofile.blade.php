@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Navbar with user's name in the upper right -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Profile</a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">{{ $user->name }}</span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">100% job complete</span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">100% on time</span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Central content with tabs -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Profile Details</div>
                <div class="card-body">
                    <!-- Tabs for BIO, Project, and Review -->
                    <ul class="nav nav-tabs" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="bio-tab" data-bs-toggle="tab" href="#bio" role="tab"
                                aria-controls="bio" aria-selected="true">BIO</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="project-tab" data-bs-toggle="tab" href="#project" role="tab"
                                aria-controls="project" aria-selected="false">Project</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="review-tab" data-bs-toggle="tab" href="#review" role="tab"
                                aria-controls="review" aria-selected="false">Review</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-3" id="profileTabContent">
                        <!-- BIO Tab -->
                        <div class="tab-pane fade show active" id="bio" role="tabpanel" aria-labelledby="bio-tab">
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Freelancer Name:</label>
                                <div class="col-md-6">
                                    <p id="name">{{ $user->name }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="servicetype" class="col-md-4 col-form-label text-md-end">Service
                                    Type:</label>
                                <div class="col-md-6">
                                    <p id="servicetype">{{ $user->servicetype }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">Service
                                    Description:</label>
                                <div class="col-md-6">
                                    <p id="description">{{ $user->description }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Project Tab -->
                        <div class="tab-pane fade" id="project" role="tabpanel" aria-labelledby="project-tab">
                            <p>Project content goes here.</p>
                        </div>

                        <!-- Review Tab -->
                        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                            <p>Review content goes here.</p>
                        </div>
                    </div>

                    <div class="row mb-0 mt-3">
                        <div class="col-md-8 offset-md-4">
                            <a href="{{ route('edit.profile') }}" class="btn btn-primary">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection