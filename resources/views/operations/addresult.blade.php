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
                  <label for="gigId" class="form-label">Gig ID</label>
                  <input type="text" name="gigId" id="gigId" class="form-control">
                  <span style="color:red">@error('gigId'){{ $message }}@enderror</span><br>
                </div>
                <div class="mb-3">
                  <label for="selectFreelancerId" class="form-label">Select Freelancer ID</label>
                  <select name="selectFreelancerId" id="selectFreelancerId" class="form-control">
                    <option value="">Select Freelancer ID</option>
                    @foreach($freelancers as $freelancer)
            <option value="{{ $freelancer->freelancer_id }}">{{ $freelancer->freelancer_id }}</option>
          @endforeach
                  </select>
                  <span style="color:red">@error('selectFreelancerId'){{ $message }}@enderror</span><br>
                </div>

                <div class="mb-3">
                  <label for="progress" class="form-label">Progress</label>
                  <input type="text" name="progress" id="progress" class="form-control">
                  <span style="color:red">@error('progress'){{ $message }}@enderror</span><br>
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