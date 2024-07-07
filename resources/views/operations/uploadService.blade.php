@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="nav-icon fas fa-upload"></i> Service</li>
                        <li class="breadcrumb-item active"><i class="fas fa-plus-circle nav-icon"></i> Add Service</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div id="notice"></div>
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-plus-circle"></i> Add New Service</h3>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form method="post" enctype="multipart/form-data" action="/upload">
                                @csrf
                                <div class="form-group">
                                    <label for="title" class="form-label">Gig Title:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                        </div>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Enter gig title">
                                    </div>
                                    <span class="text-danger">@error('title'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"
                                        placeholder="Enter description"></textarea>
                                    <span class="text-danger">@error('description'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="servicetype" class="form-label">Service Type:</label>
                                    <select name="servicetype" id="servicetype" class="form-control">
                                        <option value="" disabled selected>Select Service Type</option>
                                        <option value="painting">Painting</option>
                                        <option value="electric">Electric</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <span class="text-danger">@error('servicetype'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="price" class="form-label">Price:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">RM</span>
                                        </div>
                                        <input type="text" name="price" id="price" class="form-control"
                                            placeholder="Enter price">
                                    </div>
                                    <span class="text-danger">@error('price'){{ $message }}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <label for="image" class="form-label">Service Image:</label>
                                    <div class="custom-file">
                                        <input type="file" name="image" id="image" class="custom-file-input">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    <span class="text-danger">@error('image'){{ $message }}@enderror</span>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-save"></i> Add
                                        Service</button>
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

@section('scripts')
<script>
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    // File input label update
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
@endsection