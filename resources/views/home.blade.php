@extends('layouts.app')


@section('content')

<div class="content-wrapper">

    <div class="container-fluid">

        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-20">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item active"><i class="fas fa-home nav-icon"></i> Home</li>
                    </ol>
                </div>

            </div>





            <!-- Block Grid -->
            <div class="row">


                <!-- Block 0 -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            @foreach($freelancers as $freelancer)
                                <div class="col-md-4 mb-4">
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <h5 class="card-title"><strong>{{ $freelancer->name }}</strong></h5><br>
                                            <p class="card-text"><strong>Email:</strong> {{ $freelancer->email }}</p>
                                            <p class="card-text"><strong>Age:</strong> {{ $freelancer->age }}</p>
                                            <p class="card-text"><strong>Gender:</strong> {{ $freelancer->gender }}</p>
                                            <p class="card-text"><strong>Service Title:</strong> {{ $freelancer->title }}
                                            <p class="card-text"><strong>Service Type:</strong>
                                                {{ $freelancer->servicetype }}
                                            </p>
                                            <a href="/viewprofile/{{$freelancer->main_id}}"
                                                class="btn btn-primary mt-auto">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>




            <!-- End Block Grid -->


        </div>
    </div>
</div>




<script src="{{ mix('/js/app.js') }}"></script>
@endsection