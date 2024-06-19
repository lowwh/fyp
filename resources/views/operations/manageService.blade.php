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

            <h1>Service List</h1>

            <div class="row">
                @foreach($service as $ser)
                    <div class="col-md-4" style="background-color: white;">
                        <div class="card" style="width: 100%; background-color: lightgrey;">
                            <div class="card-body d-flex justify-content-between flex-column">

                                @can('viewAny', $ser)
                                    <div style="margin-bottom: 10px;">
                                        @if($ser->image_path)
                                            <div>
                                                <h5 class="card-title"></h5>
                                                <img src="{{ asset('storage/' . $ser->image_path) }}" alt="Service Image"
                                                    style="max-width: 200px; height: auto;">
                                            </div>
                                        @endif
                                        <br>
                                        @if($ser->userimage)
                                            <div>
                                                <h5 class="card-title"></h5>
                                                <img src="{{ asset('storage/' . $ser->userimage) }}" alt="Service Image"
                                                    class="rounded-circle" style="width: 50px; height: 50px;">
                                            </div>
                                        @endif
                                        <div style="margin-bottom: 10px;">
                                            <h5 class="card-title mb-0"
                                                style="display: inline; font-weight: bold; font-size: 1.2rem;">Gig Id:</h5>
                                            <p style="display: inline; margin-left: 10px; font-size: 1.2rem;">{{$ser['id']}}</p>
                                            <br>
                                            <h5 class="card-title mb-0"
                                                style="display: inline; font-weight: bold; font-size: 1.2rem;">Description:</h5>
                                            <p style="display: inline; margin-left: 10px; font-size: 1.2rem;">
                                                {{$ser['description']}}
                                            </p><br>
                                            <h5 class="card-title mb-0"
                                                style="display: inline; font-weight: bold; font-size: 1.2rem;">Service Type:
                                            </h5>
                                            <p style="display: inline; margin-left: 10px; font-size: 1.2rem;">
                                                {{$ser['servicetype']}}
                                            </p><br>
                                        </div>



                                    </div>
                                    @can('update', $ser)
                                        <button type="button" class="btn btn-sm custom-green-button" data-toggle="modal"
                                            data-target="#updateModal{{ $ser->id }}">
                                            Edit
                                        </button>
                                    @endcan

                                    @can('delete', $ser)
                                        <form method="POST" action="/manageService/{{$ser['id']}}" class="d-inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;">Delete</button>
                                        </form>
                                    @endcan

                                    <br><br>

                                    <div class="ml-auto" style="align-self: flex-end; background-color: lightgrey;">
                                        <h5 class="card-title" style="display: inline;">Price:</h5>
                                        <p style="display: inline; margin-left: 10px;">{{$ser['price']}}</p>
                                    </div>
                                @endcan

                            </div>
                        </div>
                    </div>

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
                                <form method="post" enctype="multipart/form-data" action="/manageservice/{{$ser['id']}}">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-body">


                                        <div class="mb-3">
                                            <label for="image" class="form-label ">Service Image: </label>
                                            <input type="file" name="image" id="image" class="form-control"
                                                value="{{$ser['image_path']}}"><br>

                                        </div>
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" class="form-control" id="title"
                                                value="{{ $ser->title }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <input type="text" name="description" class="form-control" id="description"
                                                value="{{ $ser->description }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="servicetype">Service Type</label>
                                            <input type="text" name="servicetype" class="form-control" id="servicetype"
                                                value="{{ $ser->servicetype }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label>
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
</div>

<style>
    .custom-green-button {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }

    .custom-green-button:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>

@endsection