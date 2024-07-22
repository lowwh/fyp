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
                                                    <!-- <label for="image" class="col-md-4 col-form-label text-md-end">Profile Picture:</label> -->
                                                    <div class="col-md-8">
                                                        @if($user->image_path)
                                                            <div>
                                                                <img src="{{ asset('storage/' . $user->image_path) }}" alt="Service Image"
                                                                    style="max-width: 200px; height: auto;">
                                                            </div>

                                                        @else
                                                            <div class="service-image">
                                                                <img src="{{ asset('images/noimage.jfif') }}" alt="Painting Service Back"
                                                                    class="card-img">
                                                            </div>
                                                        @endif



                                                        <div class="mb-3">


                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="id" class="col-md-4 col-form-label text-md-end">Freelancer ID:</label>
                                                    <div class="col-md-6">
                                                        <p id="id">{{ $user->freelancer_id }}</p>
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
                                                    <label for="servicetype" class="col-md-4 col-form-label text-md-end">Service
                                                        Type:</label>
                                                    <div class="col-md-6">
                                                        <p id="servicetype">{{ $user->servicetype }}</p>
                                                    </div>
                                                </div>


                                                <!-- <div class="star-rating">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="radio" id="star5" name="rating" value="5" /><label for="star5">★</label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="radio" id="star4" name="rating" value="4" /><label for="star4">★</label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3">★</label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2">★</label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="radio" id="star1" name="rating" value="1" /><label for="star1">★</label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div> -->
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

                                        <div class="button-container">

                                            <button type="button" class="btn btn-primary btn-lg px-5" data-toggle="modal"
                                                data-target="#updatedetailModal{{ $user->id }}">
                                                Edit
                                            </button>
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
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-primary btn-lg px-5" data-toggle="modal"
                        data-target="#updatedetailModal{{ $user->id }}">
                        Edit
                    </button>
                </div>



                <!-- Review Tab -->
                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <p>Review content goes here.</p>
                </div>
            </div>
    @endcan

        @can("isAdmin")
            <ul class="nav nav-tabs" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="bio-tab" data-bs-toggle="tab" href="#bio" role="tab" aria-controls="bio"
                        aria-selected="true">BIO</a>
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
                    <div class="text-center mb-3">
                        <button type="button" class="btn btn-primary btn-lg px-5" data-toggle="modal"
                            data-target="#updatedetailModal{{ $user->id }}">
                            Edit
                        </button>
                    </div>



                    <!-- Review Tab -->
                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        <p>Review content goes here.</p>
                    </div>
                </div>
        @endcan

            <!-- updatedetailModal -->
            <div class="modal fade" id="updatedetailModal{{ $user->id }}" tabindex="-1" role="dialog"
                aria-labelledby="updateModalLabel" aria-hidden="true">
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
                            <label for="image" class="form-label">Profile Image: </label>
                            <input type="file" name="image" id="image" class="form-control"><br>
                            <span style="color:red">@error('image'){{$message}}@enderror</span><br>

                            <label for="name" class="form-label">Freelancer Name: </label>
                            <input type="text" name="name" id="name" class="form-control" value="{{$user['name']}}"><br>
                            <span style="color:red">@error('name'){{$message}}@enderror</span><br>

                            <label for="gender" class="form-label">Gender: </label>
                            <input type="text" name="gender" id="gender" class="form-control"
                                value="{{$user['gender']}}"><br>
                            <span style="color:red">@error('gender'){{$message}}@enderror</span><br>


                            <label for="age" class="form-label">Age: </label>
                            <input type="text" name="age" id="age" class="form-control" value="{{$user['age']}}"><br>
                            <span style="color:red">@error('age'){{$message}}@enderror</span><br>

                            <label for="email" class="form-label">Email: </label>
                            <input type="text" name="email" id="email" class="form-control"
                                value="{{$user['email']}}"><br>
                            <span style="color:red">@error('email'){{$message}}@enderror</span><br>

                            <label for="servicetype" class="form-label">Service Type: </label>
                            <input type="text" name="servicetype" id="servicetype" class="form-control"
                                value="{{$user['servicetype']}}"><br>
                            <span style="color:red">@error('servicetype'){{$message}}@enderror</span><br>

                            <!-- Wrap the button in a div for flexbox centering -->
                            <div class="button-container">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add the CSS for flexbox centering -->



        </div>

        <style>
            .button-container {
                display: flex;
                justify-content: center;
                /* Center the button horizontally */
                margin-top: 10px;
                /* Optional: Add some space above the button */
            }

            form {
                display: flex;
                flex-direction: column;
                align-items: center;
                /* Center align items in the form */
            }
        </style>
        @endsection