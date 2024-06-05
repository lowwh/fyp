@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="nav-icon far fa-plus-square"></i> Admin Control</li>
                        <li class="breadcrumb-item"><i class="fas fa-user-friends nav-iconn"></i> Freelancer Lists</li>
                        <li class="breadcrumb-item active"><i class="fas fa-user-check nav-icon"></i> Freelancer</li>
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
                                    @foreach($freelancers as $freelancer)
                                        <tr>
                                            <td>{{ $freelancer->id }}</td>
                                            <td>{{ $freelancer->name }}</td>
                                            <td>{{ $freelancer->email }}</td>
                                            <td>{{ $freelancer->created_at }}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <button class="btn btn-warning btn-sm mr-1" data-toggle="modal"
                                                        data-target="#editModal{{ $freelancer->id }}">Edit</button>
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#changePasswordModal{{ $freelancer->id }}">Change
                                                        Password</button>
                                                    <form method="post"
                                                        action="{{ '/deletefreelancer/' . $freelancer->id }}"
                                                        style="display: inline-block;">
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
@foreach($freelancers as $freelancer)
    <div class="modal fade" id="editModal{{ $freelancer->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel{{ $freelancer->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $freelancer->id }}">Edit Freelancer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ '/freelancer/' . $freelancer->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editName{{ $freelancer->id }}">Name</label>
                            <input type="text" class="form-control" id="editName{{ $freelancer->id }}" name="name"
                                value="{{ $freelancer->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail{{ $freelancer->id }}">Email</label>
                            <input type="email" class="form-control" id="editEmail{{ $freelancer->id }}" name="email"
                                value="{{ $freelancer->email }}" required>
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

    <div class="modal fade" id="changePasswordModal{{ $freelancer->id }}" tabindex="-1" role="dialog"
        aria-labelledby="changePasswordModalLabel{{ $freelancer->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel{{ $freelancer->id }}">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/freelancers/{{$freelancer['id']}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input type="text" class="form-control" id="id" name="new_password"
                                value="{{$freelancer['id']}}" required>
                        </div>
                        <div class="form-group">
                            <label for="newPassword{{ $freelancer->id }}">New Password</label>
                            <input type="password" class="form-control" id="newPassword{{ $freelancer->id }}"
                                name="new_password" required>
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
    {{ $freelancers->links() }}
</div>

@endsection