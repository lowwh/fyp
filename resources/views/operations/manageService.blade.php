@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="container">
            <div class="row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item active"><i class="fas fa-home nav-icon"></i> Home</li>
                    </ol>
                </div>
            </div>

            <h1 class="display-4 text-center title-text mb-4">Service List</h1>

            <div class="row">
                @foreach($service as $ser)
                    <div class="col-md-4 mb-4">
                        <div class="card service-card h-100">
                            <div class="card-body d-flex flex-column">
                                @can('viewAny', $ser)
                                    @if($ser->image_path)
                                        <div class="text-center mb-3">
                                            <div class="service-image">
                                                <img src="{{ asset('storage/' . $ser->image_path) }}" alt="Service Image"
                                                    class="img-fluid rounded">
                                            </div>
                                        </div>
                                    @endif

                                    @if($ser->userimage)
                                        <div class="text-center mb-3">
                                            <div class="user-image mx-auto">
                                                <img src="{{ asset('storage/' . $ser->userimage) }}" alt="User Image"
                                                    class="rounded-circle">
                                            </div>
                                        </div>
                                    @endif

                                    <div class="gig-info text-center">
                                        <div class="gig-detail">
                                            <h5 class="card-title mb-0">Gig ID:</h5>
                                            <p>{{ $ser->id }}</p>
                                        </div>

                                        <div class="gig-detail">
                                            <h5 class="card-title mb-0">Description:</h5>
                                            <p>{{ $ser->description }}</p>
                                        </div>
                                        <div class="gig-detail">
                                            <h5 class="card-title mb-0">Service Type:</h5>
                                            <p>{{ $ser->servicetype }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <div class="price-info">
                                            <h5 class="mb-0">Price: RM {{ $ser->price }}</h5>
                                        </div>

                                        @can('update', $ser)
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#updateModal{{ $ser->id }}">
                                                Edit
                                            </button>
                                        @endcan

                                        @can('delete', $ser)
                                            <form method="POST" action="/manageService/{{ $ser->id }}" class="d-inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                @endcan
                            </div>
                        </div>

                        <!-- Update Modal -->
                        <div class="modal fade" id="updateModal{{ $ser->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="updateModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel">Update Service</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" enctype="multipart/form-data"
                                        action="/manageservice/{{ $ser->id }}">
                                        @csrf
                                        @method('POST')
                                        <div class="modal-body">
                                            <div class="form-group d-flex mb-3">
                                                <label for="image" class="form-label w-25">Service Image:</label>
                                                <input type="file" name="image" id="image" class="form-control w-75">
                                            </div>
                                            <div class="form-group d-flex mb-3">
                                                <label for="title" class="form-label w-25">Title:</label>
                                                <input type="text" name="title" class="form-control w-75" id="title"
                                                    value="{{ $ser->title }}">
                                            </div>
                                            <div class="form-group d-flex mb-3">
                                                <label for="description" class="form-label w-25">Description:</label>
                                                <input type="text" name="description" class="form-control w-75"
                                                    id="description" value="{{ $ser->description }}">
                                            </div>
                                            <div class="form-group d-flex mb-3">
                                                <label for="servicetype" class="form-label w-25">Service Type:</label>
                                                <input type="text" name="servicetype" class="form-control w-75"
                                                    id="servicetype" value="{{ $ser->servicetype }}">
                                            </div>
                                            <div class="form-group d-flex mb-3">
                                                <label for="price" class="form-label w-25">Price:</label>
                                                <input type="text" name="price" class="form-control w-75" id="price"
                                                    value="{{ $ser->price }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .title-text {
        font-weight: 700;
    }

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

    .service-card {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease-in-out;
    }

    .service-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .service-image img {
        width: 100%;
        height: 200px;
        border-radius: 10px;
        object-fit: cover;
    }

    .user-image img {
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

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .form-label {
        margin-right: 10px;
    }

    .form-control {
        flex: 1;
    }
</style>

@endsection