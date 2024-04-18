@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="nav-icon fas fa-user-graduate"></i> Student </li>
                        <li class="breadcrumb-item active"><i class="fas fa-user-friends nav-iconn"></i> Manage Student</li>

                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Email</th>
                                        <th>Student ID</th>
                                        <th style="width: 150px;">Actions</th> <!-- Adjusted width for Actions column -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $stu)
                                    <tr>
                                        <td>{{$stu['name']}}</td>
                                        <td>{{$stu['gender']}}</td>
                                        <td>{{$stu['age']}}</td>
                                        <td>{{$stu['email']}}</td>
                                        <td>{{$stu['student_id']}}</td>
                                        <td> <a href="showupdate/{{$stu['id']}}" class="btn btn-warning btn-sm mr-1">Edit</a>
                                            <a href="/delete/{{$stu['id']}}" class="btn btn-danger btn-sm">Delete</a>

                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection