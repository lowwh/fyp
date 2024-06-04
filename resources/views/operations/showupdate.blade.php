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
              <form method="post" action="/manageService/{id}">
                @csrf
                <div class="mb-3">

                  <input type="hidden" name="id" id="id" class="form-control" value="{{$update['id']}}"><br>

                </div>
                <div class="mb-3">
                  <label for="title" class="form-label">Title: </label>
                  <input type="text" name="title" id="title" class="form-control" value="{{$update['title']}}"><br>

                </div>
                <div class="mb-3">
                  <label for="description" class="form-label">Description: </label>
                  <input type="text" name="description" id="description" class="form-control"
                    value="{{$update['description']}}"><br>

                </div>
                <div class="mb-3">
                  <label for="servicetype" class="form-label">servicetype: </label>
                  <input type="text" name="servicetype" id="servicetype" class="form-control"
                    value="{{$update['servicetype']}}"><br>

                </div>
                <div class="mb-3">
                  <label for="price" class="form-label">price: </label>
                  <input type="text" name="price" id="price" class="form-control" value="{{$update['price']}}"><br>

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