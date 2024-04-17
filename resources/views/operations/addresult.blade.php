@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="fas fa-award nav-icon"></i> Result</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-folder-plus nav-icon"></i> Add Result</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div id="AddResult"></div>
        </div>
    </div>
</div>
<script src="js/app.js"></script>
@endsection