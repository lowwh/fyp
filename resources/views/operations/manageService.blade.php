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

            <div class="row"> @foreach($service as $ser)
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
                                    <h5 class="card-title" style="display: inline;">Gig Id:</h5>
                                    <p style="display: inline; margin-left: 20px;">{{$ser['id']}}</p><br>
                                    <h5 class="card-title" style="display: inline;">Description:</h5>
                                    <p style="display: inline; margin-left: 10px;">{{$ser['description']}}</p><br>
                                    <h5 class="card-title" style="display: inline;">Service Type:</h5>
                                    <p style="display: inline; margin-left: 10px;">{{$ser['servicetype']}}</p><br>


                                </div>
                                @can('update', $ser)
                                    <form method="get" action="/manageService/{{$ser['id']}}">
                                        <button
                                            style="background-color: green; color: white; border: none; padding: 5px 10px ; cursor: pointer; width: 50%">
                                            Edit
                                        </button>
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
            @endforeach
            </div>
        </div>
    </div>
</div>

@endsection