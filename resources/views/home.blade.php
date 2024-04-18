@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item active"><i class="fas fa-th-large nav-icon"></i> Dashboard</li>
                    </ol>
                </div>
            </div>

            <!-- Block Grid -->
            <div class="row">
                <!-- Block 1 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="block-content">
                                <h5 class="card-title">Add Student</h5><br>
                                <a href="addstudent" class="btn btn-primary">Go to Add Student</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Block 2 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="block-content">
                                <h5 class="card-title">Manage Student</h5><br>
                                <a href="managestudent" class="btn btn-primary">Go to Manage Student</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Block 3 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="block-content">
                                <h5 class="card-title">Add Result</h5><br>
                                <a href="addresult" class="btn btn-primary">Go to Add Result</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Block 4 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="block-content">
                                <h5 class="card-title">Manage Result</h5><br>
                                <a href="manageresult" class="btn btn-primary">Go to Manage Result</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Block 5 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="block-content">
                                <h5 class="card-title">Add Attendance</h5><br>
                                <a href="addattendance" class="btn btn-primary">Go to Add Attendance</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Block 6 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="block-content">
                                <h5 class="card-title">Manage Attendance</h5><br>
                                <a href="manageattendance" class="btn btn-primary">Go to Manage Attendance</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Block Grid -->
        </div>
    </div>
</div>
@endsection
