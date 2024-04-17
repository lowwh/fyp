@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-4">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><i class="nav-icon fas fa-user-graduate"></i> Student</a></li>
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
          <div class="row justify-content-center"> 
            <div class="col-md-6"> 
              <form method="post" action="add">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Name: </label>
                  <input type="text" name="name" id="name" class="form-control" placeholder="e.g Peter"><br>
                  <span style="color:red">@error('name'){{$message}}@enderror</span><br>
                </div>
                <div class="mb-3">
                  <label for="age" class="form-label">Age: </label>
                  <input type="text" name="age" id="age" class="form-control" placeholder="e.g 21"><br>
                  <span style="color:red">@error('age'){{$message}}@enderror</span><br>
                </div>
                 <div class="mb-3">
                  <label for="gender" class="form-label" placeholder="e.g female/male">Gender: </label>
                  <select name="gender" id="gender" class="form-control">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                  </select>
                  <span style="color:red">@error('gender'){{$message}}@enderror</span><br>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email: </label>
                  <input type="text" name="email" id="email" class="form-control" placeholder="e.g xxx@gmail.com"><br>
                  <span style="color:red">@error('email'){{$message}}@enderror</span><br>
                </div>
                <div class="mb-3">
                  <label for="student_id" class="form-label">Student ID: </label>
                  <input type="text" name="student_id" id="student_id" class="form-control" placeholder="e.g 200XXXX"><br>
                  <span style="color:red">@error('student_id'){{$message}}@enderror</span><br>
                </div>
                <div class="text-center"> 
                  <button type="submit" class="btn btn-primary">Add</button>
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
