@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="container">

            <!-- Gig Title Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-primary text-white rounded">
                        <div class="card-body text-center">
                            @foreach($results as $result)
                                <h3 class="card-title">{{$result->servicetype}}</h3>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid Format -->
            <div class="row">
                @foreach($results as $result)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            @if($result->image_path)
                                <img src="{{ asset('storage/' . $result->image_path) }}" alt="Service Image"
                                    class="card-img-top" style="max-height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">Gig ID: {{ $result->id }}</h5>
                                <p class="card-text">{{ $result->description }}</p>
                                <p class="card-text text-primary font-weight-bold">Price: RM{{ $result->price }}</p>
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                    data-target="#rateModal{{ $result->id }}">
                                    Rate
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="rateModal{{ $result->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="updateModalLabel{{ $result->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="updateModalLabel{{ $result->id }}">Give Us Feedback</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="/rating/{{$result['id']}}/{{$userid}}">
                                    @csrf
                                    <div class="modal-body">
                                        <!-- Display validation errors -->
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <input type="hidden" name="resultid" value="{{ $result->resultid }}">
                                            <input type="hidden" name="userid" value="{{ $userid }}">
                                            <label>Did this service meet
                                                your expectations?</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="expectation"
                                                    id="yes{{ $result->id }}" value="yes">
                                                <label class="form-check-label" for="yes{{ $result->id }}">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="expectation"
                                                    id="partially{{ $result->id }}" value="partially">
                                                <label class="form-check-label"
                                                    for="partially{{ $result->id }}">Partially</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="expectation"
                                                    id="no{{ $result->id }}" value="no">
                                                <label class="form-check-label" for="no{{ $result->id }}">No</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="reason{{ $result->id }}">What was the reason it achieved your
                                                expectations?</label>
                                            <textarea class="form-control" name="reason" id="reason{{ $result->id }}"
                                                rows="4"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="suggestion{{ $result->id }}">Do you have any suggestions to make it
                                                better?</label>
                                            <textarea class="form-control" name="suggestion"
                                                id="suggestion{{ $result->id }}" rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="starrating">Rating</label><br>
                                            <div class="star-rating">
                                                <input type="radio" id="star5{{ $result->id }}" name="rating"
                                                    value="5" /><label for="star5{{ $result->id }}">★</label>
                                                <input type="radio" id="star4{{ $result->id }}" name="rating"
                                                    value="4" /><label for="star4{{ $result->id }}">★</label>
                                                <input type="radio" id="star3{{ $result->id }}" name="rating"
                                                    value="3" /><label for="star3{{ $result->id }}">★</label>
                                                <input type="radio" id="star2{{ $result->id }}" name="rating"
                                                    value="2" /><label for="star2{{ $result->id }}">★</label>
                                                <input type="radio" id="star1{{ $result->id }}" name="rating"
                                                    value="1" /><label for="star1{{ $result->id }}">★</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->

                @endforeach
            </div>
            <!-- End Grid Format -->

        </div>
    </div>
</div>

<script src="{{ mix('/js/app.js') }}"></script>
<style>
    .fa-star {
        color: #ccc;
    }

    .checked {
        color: orange;
    }

    .fa-check-circle {
        color: green;
    }

    .text-success {
        color: green;
    }

    .star-rating {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 10px 0;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        font-size: 2em;
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s ease-in-out;
    }

    .star-rating input:checked~label,
    .star-rating label:hover,
    .star-rating label:hover~label {
        color: orange;
    }



    .card:hover {
        transform: scale(1.02);
        transition: transform 0.3s ease-in-out;
    }

    .modal-header {
        border-bottom: 1px solid #007bff;
    }

    .modal-footer {
        border-top: 1px solid #007bff;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .modal-content {
        border-radius: 10px;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .card-img-top {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-title {
        font-weight: bold;
        font-size: 1.25rem;
    }

    .card-text {
        font-size: 1rem;
    }

    .card-body {
        padding: 1.25rem;
    }
</style>
@endsection