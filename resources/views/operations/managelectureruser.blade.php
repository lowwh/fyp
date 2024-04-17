@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="nav-icon far fa-plus-square"></i> Admin Control</a></li>
                        <li class="breadcrumb-item"><i class="fas fa-user-friends nav-iconn"></i> User Lists</a></li>
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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
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
                                            <button class="btn btn-warning btn-sm" onclick="showEditModal({{ $lecturer->id }})">Edit</button>
                                            <form method="post" action="{{ '/deleteadmins/' . $lecturer->id }}" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="editPassword">Password</label>
                        <input type="password" class="form-control" id="editPassword" name="password" required>
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

<!-- Pagination links -->
<div class="d-flex justify-content-center">
    {{ $lecturers->links() }}
</div>

<script src="js/app.js"></script>

<script>
    function showEditModal(userId) {
        console.log('Opening edit modal for user with ID:', userId);
        // Fetch user data from server and fill in modal fields
        $.get('/lecturers/' + userId, function(data) {
            $('#editForm').attr('action', '/lecturers/' + userId);
            $('#editName').val(data.name);
            $('#editEmail').val(data.email);
            $('#editModal').modal('show');
        });
    }
</script>

@endsection