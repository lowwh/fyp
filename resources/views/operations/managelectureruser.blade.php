@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="nav-icon far fa-plus-square"></i> Admin Control</li>
                        <li class="breadcrumb-item"><i class="fas fa-user-friends nav-iconn"></i> User Lists</li>
                        <li class="breadcrumb-item active"><i class="fas fa-user-tie nav-icon"></i> Lecturer</li>
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
                                        <th style="width: 5%">ID</th>
                                        <th style="width: 30%">Name</th>
                                        <th style="width: 30%">Email</th>
                                        <th style="width: 15%">Created At</th>
                                        <th style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lecturers as $lecturer)
                                    <tr>
                                        <td>{{ $lecturer->id }}</td>
                                        <td>{{ $lecturer->name }}</td>
                                        <td>{{ $lecturer->email }}</td>
                                        <td>{{ $lecturer->created_at }}</td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#editModal{{ $lecturer->id }}">Edit</button>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#changePasswordModal{{ $lecturer->id }}">Change Password</button>
                                                <form method="post" action="{{ '/deletelecturers/' . $lecturer->id }}" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
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

<!-- Edit Modals -->
@foreach($lecturers as $lecturer)
<div class="modal fade" id="editModal{{ $lecturer->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $lecturer->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $lecturer->id }}">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ '/lecturers/' . $lecturer->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editName{{ $lecturer->id }}">Name</label>
                        <input type="text" class="form-control" id="editName{{ $lecturer->id }}" name="name" value="{{ $lecturer->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail{{ $lecturer->id }}">Email</label>
                        <input type="email" class="form-control" id="editEmail{{ $lecturer->id }}" name="email" value="{{ $lecturer->email }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordModal{{ $lecturer->id }}" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel{{ $lecturer->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel{{ $lecturer->id }}">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ '/lecturersChangePassword/' . $lecturer->id }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="newPassword{{ $lecturer->id }}">New Password</label>
                        <input type="password" class="form-control" id="newPassword{{ $lecturer->id }}" name="new_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Pagination links -->
<div class="d-flex justify-content-center">
    {{ $lecturers->links() }}
</div>

@endsection
