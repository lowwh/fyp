@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="container">

            <!-- Gig Title Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-primary text-white rounded">
                        <div class="card-body">
                            @foreach($results as $result)
                                <h3 class="card-title text-center">{{$result->servicetype}}</h3>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid Format -->
            <div class="row">
                @foreach($results as $result)
                    <div class="col-12 mb-4">
                        <div class="card" style="border: 1px solid #ccc; padding: 10px;">
                            @if($result->image_path)
                                <img src="{{ asset('storage/' . $result->image_path) }}" alt="Service Image"
                                    class="card-img-top" style="max-width: 30%; height: auto;">
                            @endif
                            <div class="card-body">
                                <p class="card-title">Gig ID: {{ $result->id }}</p>
                                <p class="card-text">Gig Description:{{ $result->description }}</p>
                                <p class="card-text">Price:{{ $result->price }}</p>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#rateModal{{ $result->id }}">
                                    Rate
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="rateModal{{ $result->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="updateModalLabel{{ $result->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #007bff; color: white;">
                                    <h5 class="modal-title" id="updateModalLabel{{ $result->id }}">Give Us a Feedback</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" style="color: white;">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="/rating/{{$result['id']}}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Did this service meet your expectations?</label><br>
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
                                            <label for="reason{{ $result->id }}">What was the reason it could not achieve
                                                your expectations?</label>
                                            <textarea class="form-control" name="reason" id="reason{{ $result->id }}"
                                                rows="4"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="suggestion{{ $result->id }}">Do you have any suggestion to make it
                                                better?</label>
                                            <textarea class="form-control" name="suggestion"
                                                id="suggestion{{ $result->id }}" rows="5"></textarea>
                                        </div>
                                        <div class="star-rating">
                                            <input type="radio" id="star5{{ $result->id }}" name="rating" value="5" /><label
                                                for="star5{{ $result->id }}">★</label>
                                            <input type="radio" id="star4{{ $result->id }}" name="rating" value="4" /><label
                                                for="star4{{ $result->id }}">★</label>
                                            <input type="radio" id="star3{{ $result->id }}" name="rating" value="3" /><label
                                                for="star3{{ $result->id }}">★</label>
                                            <input type="radio" id="star2{{ $result->id }}" name="rating" value="2" /><label
                                                for="star2{{ $result->id }}">★</label>
                                            <input type="radio" id="star1{{ $result->id }}" name="rating" value="1" /><label
                                                for="star1{{ $result->id }}">★</label>
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