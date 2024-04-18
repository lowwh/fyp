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
                        <li class="breadcrumb-item active"><i class="fas fa-user-cog nav-icon"></i> Admin</li>
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
                                        <th style="width: 18%">Created At</th>
                                        <th style="width: 27%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->id }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->created_at }}</td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#editModal{{ $admin->id }}">Edit</button>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#changePasswordModal{{ $admin->id }}">Change Password</button>
                                                <form method="post" action="{{ '/deleteadmins/' . $admin->id }}" style="display: inline-block;">
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
@foreach($admins as $admin)
<div class="modal fade" id="editModal{{ $admin->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $admin->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $admin->id }}">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ '/admins/' . $admin->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editName{{ $admin->id }}">Name</label>
                        <input type="text" class="form-control" id="editName{{ $admin->id }}" name="name" value="{{ $admin->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail{{ $admin->id }}">Email</label>
                        <input type="email" class="form-control" id="editEmail{{ $admin->id }}" name="email" value="{{ $admin->email }}" required>
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

<div class="modal fade" id="changePasswordModal{{ $admin->id }}" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel{{ $admin->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel{{ $admin->id }}">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ '/adminsChangePassword/' . $admin->id }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="newPassword{{ $admin->id }}">New Password</label>
                        <input type="password" class="form-control" id="newPassword{{ $admin->id }}" name="new_password" required>
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
    {{ $admins->links() }}
</div>

@endsection
