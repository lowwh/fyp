@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="fas fa-user-check nav-icon"></i> Attendance </li>
                        <li class="breadcrumb-item active"><i class="fas fa-calendar-check nav-icon"></i> Add Attendance</li>
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
              <form method="post" action="addAttendance">
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
                  <select name="student_id" id="selectStudentId" class="form-control">
                    <option value="">Select Student ID</option>
                    @foreach($students as $student)
                    <option value="{{ $student->student_id }}">{{ $student->student_id }}</option>
                    @endforeach
                  </select>
                  <span style="color:red">@error('selectStudentId'){{ $message }}@enderror</span><br>
                </div>
                <div class="mb-3">
                    <label for="attendance" class="form-label">Attendance Percentage %</label>
                    <input type="text" name="attendance" id="attendance" class="form-control">
                    <span style="color:red">@error('attendance'){{ $message }}@enderror</span><br>
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