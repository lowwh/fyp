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
                <div class="col-md-12" style="display: flex;">
                    <div class="card" style="width: 100%;">
                        <div class="card-body d-flex justify-content-between">
                            <div class="block-content">
                                <h5 class="card-title">Freelancer</h5><br>
                                <div id="freelancer" style="display: flex; flex-wrap: nowrap;"></div>
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