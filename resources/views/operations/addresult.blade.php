@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-4">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><i class="nav-icon fas fa-user-graduate"></i> Result</a></li>
            <li class="breadcrumb-item active"><i class="fas fa-plus-circle nav-icon"></i> Add Result</li>
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
              <form method="post" action="addResult">
                @csrf
                @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
                <div class="mb-3">
                  <label for="selectStudentId" class="form-label">Select Student ID</label>
                  <select name="selectStudentId" id="selectStudentId" class="form-control">
                    <option value="">Select Student ID</option>
                    @foreach($students as $student)
                    <option value="{{ $student->student_id }}">{{ $student->student_id }}</option>
                    @endforeach
                  </select>
                  <span style="color:red">@error('selectStudentId'){{ $message }}@enderror</span><br>
                </div>
                <div class="mb-3">
                  <label for="selectCourse" class="form-label">Select Course</label>
                  <select name="selectCourse" id="selectCourse" class="form-control">
                    <option value="">Select Course</option>
                    @foreach($coursesOptions as $course)
                    <option value="{{ $course }}">{{ $course }}</option>
                    @endforeach
                  </select>
                  <span style="color:red">@error('selectCourse'){{ $message }}@enderror</span><br>
                </div>
                <div class="mb-3">
                    <label for="resultScore" class="form-label">Result Score</label>
                    <input type="text" name="result_score" id="resultScore" class="form-control">
                    <span style="color:red">@error('result_score'){{ $message }}@enderror</span><br>
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

<script>
  // You may need to include your JavaScript code for handling dynamic behavior here
</script>

@endsection
