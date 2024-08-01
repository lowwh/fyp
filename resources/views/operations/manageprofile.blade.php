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
                        <span class="nav-link">{{ $user->name }}</span>
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
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10">
            <div class="card mb-4 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <!-- User Info -->
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            @if($user->image_path)
                                <img src="{{ asset('storage/' . $user->image_path) }}" alt="Profile Image"
                                    class="img-fluid rounded-circle border border-2 border-light"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/noimage.jfif') }}" alt="No Image"
                                    class="img-fluid rounded-circle border border-2 border-light"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h3 class="font-weight-bold mb-2">{{ $user->name }}</h3>
                            <p class="text-muted mb-4">{{ $user->servicetype }}</p>
                            <p class="text-muted mb-4">
                                <span class="badge bg-success">100% Job Complete</span>
                                <span class="badge bg-success">100% On Time</span>
                            </p>
                        </div>
                    </div>

                    <!-- Tabs for BIO, Project, and Review -->
                    <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="bio-tab" data-bs-toggle="tab" href="#bio" role="tab"
                                aria-controls="bio" aria-selected="true">BIO</a>
                        </li>
                        @can('isFreelancer')
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="project-tab" data-bs-toggle="tab" href="#project" role="tab"
                                    aria-controls="project" aria-selected="false">Project</a>
                            </li>
                        @endcan
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="review-tab" data-bs-toggle="tab" href="#review" role="tab"
                                aria-controls="review" aria-selected="false">Review</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content" id="profileTabContent">
                        <!-- BIO Tab -->
                        <div class="tab-pane fade show active" id="bio" role="tabpanel" aria-labelledby="bio-tab">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Freelancer ID:</h5>
                                    <p>{{ $user->freelancer_id }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Freelancer Name:</h5>
                                    <p>{{ $user->name }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Gender:</h5>
                                    <p>{{ $user->gender }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Age:</h5>
                                    <p>{{ $user->age }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Email:</h5>
                                    <p>{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Service Type:</h5>
                                    <p>{{ $user->servicetype }}</p>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-primary btn-lg px-5" data-bs-toggle="modal"
                                    data-bs-target="#updatedetailModal{{ $user->id }}">
                                    Edit
                                </button>
                            </div>
                        </div>

                        @can('isFreelancer')
                            <!-- Project Tab -->
                            <div class="tab-pane fade" id="project" role="tabpanel" aria-labelledby="project-tab">
                                <p>Project content goes here.</p>
                            </div>
                        @endcan

                        <!-- Review Tab -->
                        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                            <p>Review content goes here.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Detail Modal -->
    <div class="modal fade" id="updatedetailModal{{ $user->id }}" tabindex="-1" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title" id="updateModalLabel">Update Profile Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" enctype="multipart/form-data" action="/uploadphoto/{{$user['id']}}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image: </label>
                            <input type="file" name="image" id="image" class="form-control">
                            <span class="text-danger">@error('image'){{ $message }}@enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Freelancer Name: </label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user['name'] }}">
                            <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender: </label>
                            <input type="text" name="gender" id="gender" class="form-control"
                                value="{{ $user['gender'] }}">
                            <span class="text-danger">@error('gender'){{ $message }}@enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age: </label>
                            <input type="text" name="age" id="age" class="form-control" value="{{ $user['age'] }}">
                            <span class="text-danger">@error('age'){{ $message }}@enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email: </label>
                            <input type="text" name="email" id="email" class="form-control"
                                value="{{ $user['email'] }}">
                            <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="servicetype" class="form-label">Service Type: </label>
                            <input type="text" name="servicetype" id="servicetype" class="form-control"
                                value="{{ $user['servicetype'] }}">
                            <span class="text-danger">@error('servicetype'){{ $message }}@enderror</span>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-navbar .navbar {
        border-bottom: 1px solid #eaeaea;
    }

    .profile-navbar .navbar-brand {
        font-size: 1.25rem;
        font-weight: bold;
        color: #333;
    }

    /* Navbar */
    .navbar {
        border-bottom: 1px solid #eaeaea;
    }

    .navbar-brand {
        font-size: 1.25rem;
        font-weight: bold;
        color: #333;
    }

    /* Card */
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 2rem;
    }

    /* Profile Image */
    .img-fluid {
        border: 3px solid #007bff;
        border-radius: 50%;
        width: 150px;
        height: 150px;
        object-fit: cover;
    }

    /* Tabs */
    .nav-tabs {
        border-bottom: 2px solid #007bff;
    }

    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
    }

    .nav-tabs .nav-link.active {
        color: #007bff;
        background-color: #fff;
        border-color: #007bff #007bff #fff;
    }

    /* Modal */
    .modal-content {
        border: none;
        border-radius: 0.75rem;
    }

    .modal-header {
        border-bottom: none;
        background-color: #f8f9fa;
    }

    .btn-close {
        background: none;
        border: none;
        color: #007bff;
    }


    /* Responsive */
    @media (max-width: 767.98px) {
        .navbar-nav {
            margin-top: 0.5rem;
        }
    }
</style>
@endsection