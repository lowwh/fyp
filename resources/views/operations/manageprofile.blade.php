@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Navbar with user's name in the upper right -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
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
                            <a class="nav-link active" id="bio-tab" data-bs-toggle="tab" href="#bio" role="tab" aria-controls="bio" aria-selected="true">BIO</a>
                        </li>
                        @can('isFreelancer')
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="project-tab" data-bs-toggle="tab" href="#project" role="tab" aria-controls="project" aria-selected="false">Project</a>
                            </li>
                        @endcan
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="review-tab" data-bs-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Review</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-3" id="profileTabContent">
                        <!-- BIO Tab -->
                        <div class="tab-pane fade show active" id="bio" role="tabpanel" aria-labelledby="bio-tab">
                            <div class="text-center mb-4">
                                @if($user->image_path)
                                    <img src="{{ asset('storage/' . $user->image_path) }}" alt="Profile Image" class="rounded-circle img-fluid" style="max-width: 150px;">
                                @else
                                    <img src="{{ asset('images/noimage.jfif') }}" alt="No Image" class="rounded-circle img-fluid" style="max-width: 150px;">
                                @endif
                            </div>

                            <div class="row mb-3">
                                <label for="freelancer_id" class="col-md-4 col-form-label text-md-end">Freelancer ID:</label>
                                <div class="col-md-6">
                                    <p id="freelancer_id">{{ $user->freelancer_id }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Freelancer Name:</label>
                                <div class="col-md-6">
                                    <p id="name">{{ $user->name }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="gender" class="col-md-4 col-form-label text-md-end">Gender:</label>
                                <div class="col-md-6">
                                    <p id="gender">{{ $user->gender }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="age" class="col-md-4 col-form-label text-md-end">Age:</label>
                                <div class="col-md-6">
                                    <p id="age">{{ $user->age }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email:</label>
                                <div class="col-md-6">
                                    <p id="email">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="servicetype" class="col-md-4 col-form-label text-md-end">Service Type:</label>
                                <div class="col-md-6">
                                    <p id="servicetype">{{ $user->servicetype }}</p>
                                </div>
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

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-primary btn-lg px-5" data-toggle="modal" data-target="#updatedetailModal{{ $user->id }}">
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Detail Modal -->
    <div class="modal fade" id="updatedetailModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Profile Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                            <input type="text" name="gender" id="gender" class="form-control" value="{{ $user['gender'] }}">
                            <span class="text-danger">@error('gender'){{ $message }}@enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age: </label>
                            <input type="text" name="age" id="age" class="form-control" value="{{ $user['age'] }}">
                            <span class="text-danger">@error('age'){{ $message }}@enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email: </label>
                            <input type="text" name="email" id="email" class="form-control" value="{{ $user['email'] }}">
                            <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                        </div>
                        <div class="mb-3">
                            <label for="servicetype" class="form-label">Service Type: </label>
                            <input type="text" name="servicetype" id="servicetype" class="form-control" value="{{ $user['servicetype'] }}">
                            <span class="text-danger">@error('servicetype'){{ $message }}@enderror</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #f8f9fa;
        border-color: #dee2e6 #dee2e6 #f8f9fa;
    }
    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
</style>
@endsection
