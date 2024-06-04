@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="nav-icon fas fa-upload"></i> Service</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-plus-circle nav-icon"></i> Add Service</li>
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
                            <form method="post" enctype="multipart/form-data"
                                action="https://imagekit.io/does-not-exists">
                                <input type="file" name="file">
                                <button>Upload</button>
                            </form>
                            <form method="post" enctype="multipart/form-data" action="/upload">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Gig Title: </label>
                                    <input type="text" name="title" id="title" class="form-control" <br>
                                    <span style="color:red">@error('title'){{$message}}@enderror</span><br>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description: </label>
                                    <textarea name="description" id="description" class="form-control"></textarea><br>
                                    <span style="color:red">@error('description'){{$message}}@enderror</span><br>
                                </div>
                                <div class="mb-3">
                                    <label for="servicetype" class="form-label" placeholder="e.g female/male">Service
                                        Type:
                                    </label>
                                    <select name="servicetype" id="servicetype" class="form-control">
                                        <option value="">Select Service Type</option>
                                        <option value="painting">Painting</option>
                                        <option value="electric">Electric</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <span style="color:red">@error('gender'){{$message}}@enderror</span><br>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price: </label>
                                    <input type="text" name="price" id="price" class="form-control"><br>
                                    <span style="color:red">@error('price'){{$message}}@enderror</span><br>
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