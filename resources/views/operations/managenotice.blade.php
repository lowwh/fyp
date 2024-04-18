@extends('layouts.app')

@section('content')
<div class="content-wrapper">


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="fas fa-bell nav-icon"></i> Notice</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-tasks nav-icon"></i> Manage Notice</li>
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
                    Notice
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Notice Title</th>
                                        <th>Notice Content</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notices as $notice)
                                    <tr id="notice-{{ $notice['id'] }}">
                                        <td>{{ $notice['id'] }}</td>
                                        <td>{{ $notice['notice_title'] }}</td>
                                        <td>{{ $notice['notice_content'] }}</td>
                                        <td>{{ $notice['created_at'] }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Notice Actions">
                                                <button type="button" class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#modal-{{ $notice['id'] }}">
                                                    Edit
                                                </button>

                                                <form method="post" action="{{ 'deletenotice/' . $notice['id'] }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>

                                                <!-- Modal -->
                                                <div class="modal fade" id="modal-{{ $notice['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form method="post" action="managenotice/{{ $notice['id'] }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="title" class="form-label">Title</label>
                                                                        <input type="text" name="notice_title" class="form-control" id="notice_title" value="{{ $notice['notice_title'] }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="content" class="form-label">Content</label>
                                                                        <input type="text" name="notice_content" class="form-control" id="notice_content" value="{{ $notice['notice_content'] }}" style="height: 300px">
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <script src="js/app.js"></script>
                    </div>
                </div>
            </div>
            {{ $notices->links() }}

        </div>
    </div>

</div>
@endsection