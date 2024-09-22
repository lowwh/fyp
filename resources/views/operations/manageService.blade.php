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
                    <div class="col-md-6 mb-4">
                        <div class="split-view">
                            <div class="split-view-left">
                                <img src="{{ asset('storage/' . $ser->image_path) }}" alt="Service Image" class="img-fluid">
                            </div>
                            <div class="split-view-right">
                                <h5 class="mb-1">{{ $ser->title }}</h5>
                                <p class="mb-2">{{ $ser->description }}</p>
                                <p class="mb-2"><strong>Price:</strong> {{ $ser->price }}</p>
                                <p class="mb-2"><strong>Service Type:</strong> {{ $ser->servicetype }}</p>
                                <div class="actions">
                                    @can('update', $ser)
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#updateModal{{ $ser->id }}">Edit</button>
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
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Update Modals -->
            @foreach($service as $ser)
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
                            <form method="post" enctype="multipart/form-data" action="/manageservice/{{ $ser->id }}">
                                @csrf
                                @method('POST')
                                <div class="modal-body">
                                    <!-- Form Fields -->
                                    <div class="form-group mb-3">
                                        <label for="image" class="form-label">Service Image:</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label">Title:</label>
                                        <input type="text" name="title" class="form-control" id="title"
                                            value="{{ $ser->title }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="description" class="form-label">Description:</label>
                                        <input type="text" name="description" class="form-control" id="description"
                                            value="{{ $ser->description }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="servicetype" class="form-label">Service Type:</label>
                                        <input type="text" name="servicetype" class="form-control" id="servicetype"
                                            value="{{ $ser->servicetype }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">Price:</label>
                                        <input type="text" name="price" class="form-control" id="price"
                                            value="{{ $ser->price }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    /* Title Styling */
    .title-text {
        font-weight: 800;
        font-size: 2.5rem;
        color: #343a40;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 30px;
    }

    /* Split View */
    .split-view {
        display: flex;
        border: 1px solid #ddd;
        border-radius: .5rem;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s, opacity 0.5s;
        opacity: 0;
        animation: fadeIn 0.5s forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .split-view:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .split-view-left {
        flex: 1;
        overflow: hidden;
        position: relative;
    }

    .split-view-left img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: opacity 0.3s;
    }

    .split-view-left img:hover {
        opacity: 0.9;
    }

    .split-view-right {
        flex: 2;
        padding: 15px;
        background-color: #f8f9fa;
    }

    .split-view-right h5 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        transition: color 0.3s;
    }

    .split-view-right h5:hover {
        color: #007bff;
    }

    .split-view-right p {
        font-size: 1rem;
        color: #555;
        margin-bottom: 0.5rem;
    }

    .split-view-right .actions {
        margin-top: 10px;
        text-align: right;
    }

    .actions .btn {
        transition: background-color 0.3s, color 0.3s;
    }

    .actions .btn-primary:hover {
        background-color: #0056b3;
        color: #fff;
    }

    .actions .btn-danger:hover {
        background-color: #c82333;
        color: #fff;
    }

    .modal-content {
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* Custom Scrollbars */
    .split-view-right {
        overflow-y: auto;
    }

    .split-view-right::-webkit-scrollbar {
        width: 8px;
    }

    .split-view-right::-webkit-scrollbar-thumb {
        background-color: #007bff;
        border-radius: 10px;
    }

    .split-view-right::-webkit-scrollbar-track {
        background-color: #f8f9fa;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .split-view {
            flex-direction: column;
        }

        .split-view-left img {
            height: 150px;
        }

        .split-view-right {
            padding: 10px;
        }
    }
</style>

@endsection