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
                    @can('isFreelancer')
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
                                                    <label for="image" class="col-md-4 col-form-label text-md-end">Profile Picture:</label>
                                                    <div class="col-md-8">
                                                        @if($user->image_path)
                                                            <div>
                                                                <img src="{{ asset('storage/' . $user->image_path) }}" alt="Service Image"
                                                                    style="max-width: 200px; height: auto;">
                                                            </div>
                                                        @endif
                                                        <div class="mb-3">
                                                            <form method="get" action="/uploadphoto/{{$user->id}}">
                                                                <button type="submit" class="btn btn-primary">Upload</button>
                                                            </form>
                                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                                data-target="#updateModal{{ $user->id }}">
                                                                Edit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

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
                                                <div class="star-rating">
                                                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5">★</label>
                                                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4">★</label>
                                                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3">★</label>
                                                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2">★</label>
                                                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1">★</label>
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
                    @endcan

    @can("isUser")
        <ul class="nav nav-tabs" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="bio-tab" data-bs-toggle="tab" href="#bio" role="tab" aria-controls="bio"
                    aria-selected="true">BIO</a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" id="review-tab" data-bs-toggle="tab" href="#review" role="tab" aria-controls="review"
                    aria-selected="false">Review</a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="profileTabContent">
            <!-- BIO Tab -->
            <div class="tab-pane fade show active" id="bio" role="tabpanel" aria-labelledby="bio-tab">

                <label for="image" class="col-md-4 col-form-label text-md-end">Profile Picture:</label>
                <div class="col-md-8">
                    @if($user->image_path)
                        <div>
                            <img src="{{ asset('storage/' . $user->image_path) }}" alt="Service Image"
                                style="max-width: 200px; height: auto;">
                        </div>

                    @endif
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#updateModal{{ $user->id }}">
                        Edit
                    </button>
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">User Name:</label>
                        <div class="col-md-6">
                            <p id="name">{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="age" class="col-md-4 col-form-label text-md-end">User Age:</label>
                        <div class="col-md-6">
                            <p id="age">{{ $user->age }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="gender" class="col-md-4 col-form-label text-md-end">Gender
                            :</label>
                        <div class="col-md-6">
                            <p id="gender">{{ $user->gender }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email
                            :</label>
                        <div class="col-md-6">
                            <p id="email">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>



                <!-- Review Tab -->
                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <p>Review content goes here.</p>
                </div>
            </div>
    @endcan
        <div class="modal fade" id="updateModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Profile Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" enctype="multipart/form-data" action="/uploadphoto/{{$user['id']}}">
                        @csrf
                        <label for="image" class="form-label">Profile Image: </label>
                        <input type="file" name="image" id="image" class="form-control"><br>
                        <span style="color:red">@error('image'){{$message}}@enderror</span><br>
                        <button type="submit" class="btn btn-primary">upload</button>
                    </form>
                </div>
            </div>
        </div>


    </div>
    @endsection