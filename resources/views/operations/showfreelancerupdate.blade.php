@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="fas fa-bell nav-icon"></i> Notice</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-plus-circle nav-icon"></i> Add Student</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div id="notice"></div>
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-center"> <!-- Center the form horizontally -->
                        <div class="col-md-6"> <!-- Set the width of the form -->
                            <form method="post" action="/update/{id}">
                                @csrf
                                <div class="mb-3">

                                    <input type="hidden" name="id" id="id" class="form-control"
                                        value="{{$freelancers['id']}}"><br>

                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name: </label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{$freelancers['name']}}"><br>

                                </div>
                                <div class="mb-3">
                                    <label for="age" class="form-label">Age: </label>
                                    <input type="text" name="age" id="age" class="form-control"
                                        value="{{$freelancers['age']}}"><br>

                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender: </label>
                                    <input type="text" name="gender" id="servicetype" class="form-control"
                                        value="{{$freelancers['gender']}}"><br>

                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email: </label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        value="{{$freelancers['email']}}"><br>

                                </div>

                                <div class="text-center"> <!-- Center the button -->
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection