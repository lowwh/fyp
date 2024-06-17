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
                                            @if($freelancer->serviceimage)
                                                <div>
                                                    <img src="{{ asset('storage/' . $freelancer->serviceimage) }}"
                                                        alt="Service Image" style="max-width: 200px; height: auto;">
                                                </div>
                                            @endif
                                            <br>
                                            @if($freelancer->image_path)
                                                <div>
                                                    <h5 class="card-title"></h5>
                                                    <img src="{{ asset('storage/' . $freelancer->image_path) }}"
                                                        alt="Service Image" class="rounded-circle"
                                                        style="width: 50px; height: 50px;"
                                                        style="max-width: 200px; height: auto; ">
                                                </div>
                                            @endif
                                            <h5 class="card-title"><strong>{{ $freelancer->name }}</strong></h5><br>


                                            <p class="card-text"><strong>Gig ID:</strong> {{ $freelancer->serviceid }}</p>
                                            <p class="card-text"><strong>Gig Title:</strong> {{ $freelancer->title }}
                                            <p class="card-text"><strong>Gig Type:</strong>
                                                {{ $freelancer->servicetype }}
                                            </p>
                                            <a href="/viewprofile/{{$freelancer->main_id}}"
                                                class="btn btn-primary mt-auto">View Profile</a><br>
                                            <a href="/viewservice/{{$freelancer->main_id}}"
                                                class="btn btn-secondary mt-auto">View Service</a>
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