@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="container">

            <!-- List Format -->
            <div class="row">
                @if($results->isNotEmpty())
                    @foreach($results as $result)
                        <div class="col-md-4 mb-4">
                            <div class="list-item" style="border: 1px solid #ccc; padding: 10px;">
                                @if($result->image_path)
                                    <div>
                                        <img src="{{ asset('storage/' . $result->image_path) }}" alt="Service Image"
                                            style="max-width: 200px; height: auto;">
                                    </div>
                                @endif
                                <br>
                                @if($result->userimage)
                                    <div>
                                        <h5 class="card-title"></h5>
                                        <img src="{{ asset('storage/' . $result->userimage) }}" alt="User Image"
                                            class="rounded-circle" style="width: 50px; height: 50px;">
                                    </div>
                                @endif

                                <p><strong>Gig ID:</strong> {{ $result->gig_id }}</p>


                                <!-- Display Rating as Stars -->
                                <p><strong>Rating:</strong>
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $result->rating)
                                            <span class="fa fa-star checked"></span>
                                        @else
                                            <span class="fa fa-star"></span>
                                        @endif
                                    @endfor
                                </p>
                                <p><strong></strong> {{ $result->reason }}</p>

                                <!-- Display Green Tick for Completed Task -->
                                <p><i class="fa fa-check-circle text-success"></i> Completed</p>

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-gray-300 rounded-lg p-5 mb-5"
                        style="background-color: white; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 100%; max-width: 600px; margin: 0 auto;">
                        <p style="font-size: 32px; font-weight: bold;">No History Service yet</p>
                    </div>


                @endif
            </div>
            <!-- End List Format -->

        </div>
    </div>
</div>

<script src="{{ mix('/js/app.js') }}"></script>
<style>
    .fa-star {
        color: #ccc;
        /* Default star color */
    }

    .checked {
        color: orange;
        /* Color for filled stars */
    }

    .fa-check-circle {
        color: green;
        /* Color for green tick */
    }

    .text-success {
        color: green;
        /* Bootstrap class for green text */
    }
</style>
@endsection