@extends('layouts.app')

@section('content')
    <div class="container">
        <h1
            style="text-align:center;  color: #007bff;  font-family: 'Arial', sans-serif;  font-size: 36px; font-weight: bold">
            Manage Notice</h1>
        <div id="notice"></div>
        <div class="card">
            <div class="card-header">
                Notice
            </div>
            <div class="card-body">
                <div class="container">
                    @foreach ($notices as $notice)
                        <div class="row justify-content-between border">
                            {{ $notice['notice_title'] }}
                            <div class="row">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mr-1" data-bs-toggle="modal"
                                    data-bs-target="#modal-{{ $notice['id'] }}">
                                    Edit
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modal-{{ $notice['id'] }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="managenotice/{{ $notice['id'] }}">
                                              @csrf
                                              @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="title" class="form-label">Title</label>
                                                        <input type="text" name="notice_title" class="form-control"
                                                            id="notice_title" value="{{ $notice['notice_title'] }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="content" class="form-label">Content</label>
                                                        <input type="text" name="notice_content" class="form-control"
                                                            id="notice_content" value="{{ $notice['notice_content'] }}"
                                                            style="height: 300px">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <form method="post" action={{ 'deletenotice/' . $notice['id'] }}>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    <script src="js/app.js"></script>
                </div>
            </div>
        </div>
        {{ $notices->links() }}

    </div>
@endsection
