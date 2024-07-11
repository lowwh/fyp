@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* Custom CSS for styling */
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            margin-top: 20px;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .result-container {
            background-color: #E5E5E5;
            padding: 10px;
            margin-top: 20px;
        }

        .service-image {
            margin-bottom: 10px;
        }

        @media print {

            .container form,
            .container button,
            .text-center {
                display: none;
            }
        }

        /* Example CSS for stars */
        .fa {
            color: gold;
            /* Adjust color as needed */
            font-size: 18px;
            /* Adjust size as needed */
        }
    </style>

</head>

<body>

    <!-- Content section -->
    <div class="container">
        <h2 class="text-center">Search for Freelancer Results</h2>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="post" action="{{ route('search.result') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" id="servicetype" name="servicetype" class="form-control"
                            placeholder="Enter Service Type" aria-label="Enter Service Type"
                            aria-describedby="searchButton">
                        <button class="btn btn-primary" type="submit" id="searchButton">Search</button>
                    </div>
                </form>

                <div style="background-color: white;">
                    <div style="display: inline-block; margin: 10px;">
                        <button id="sortByDateButton" class="btn btn-primary" onclick="sortResultsByDate()">
                            Sort by Date
                            <i id="sortByDateIcon" class="fas fa-spinner fa-spin" style="display: none;"></i>
                        </button>
                    </div>

                    <div style="display: inline-block; margin: 10px;">
                        <button id="sortButton" class="btn btn-primary" onclick="sortResultsByState()">
                            Sort by State
                            <i id="sortIcon" class="fas fa-spinner fa-spin" style="display: none;"></i>
                        </button>
                    </div>

                    <div style="display: inline-block; margin: 10px;">
                        <button id="sortByRatingButton" class="btn btn-primary" onclick="sortResultsByRating()">
                            Sort by Rating
                            <i id="sortByRatingIcon" class="fas fa-spinner fa-spin" style="display: none;"></i>
                        </button>
                    </div>

                    <div style="display: inline-block; margin: 10px;">
                        <button id="sortByPriceButton" class="btn btn-primary" onclick="sortResultsByPrice()">
                            Sort by Price
                            <i id="sortByPriceIcon" class="fas fa-spinner fa-spin" style="display: none;"></i>
                        </button>
                    </div>
                </div>

                @if(isset($results) && !$results->isEmpty())
                    <div class="card">
                        <div class="card-header text-black" style="background-color: #E5E5E5;">
                            Freelancer Result
                        </div>
                        <div id="notification" class="alert alert-success" style="display: none;"></div>
                        <div class="card-body">
                            @foreach($results as $result)
                                <div class="result-container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @if($result->serviceimage)
                                                <div class="service-image">
                                                    <img src="{{ asset('storage/' . $result->serviceimage) }}" alt="Service Image"
                                                        class="img-fluid rounded">
                                                </div>
                                            @else
                                                <div class="service-image">
                                                    <img src="{{ asset('images/noimage.jfif') }}" alt="Painting Service Back"
                                                        class="card-img">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <p><strong>Service Title:</strong> {{ $result->title }}</p>

                                            <p class="service-state"><strong>Service State:</strong> {{ $result->state }}</p>
                                            <p class="service-price"><strong>Service Price:</strong> {{ $result->price }}
                                            </p>
                                            @if($result->gigs_count > 0)
                                                <p class="rating-state"><strong>Total Rating:</strong> {{ $result->gigs_count }}</p>
                                            @else
                                                <p class="rating-state"><strong>Total Rating:</strong> 0</p>
                                            @endif



                                            <p class="service-date"><strong>Posted On:</strong>
                                                {{ $result->service_created_date }}</p>
                                            <a href="/viewservice/{{ $result->userid }}/{{ $result->serviceid }}"
                                                class="btn btn-secondary mt-auto">View</a>
                                        </div>


                                    </div>
                                </div>
                            @endforeach

                            <!-- Print button -->
                            <div class="text-center mt-3">
                                <button class="btn btn-primary" onclick="window.print()">Print</button>
                            </div>
                        </div>
                    </div>
                @elseif(isset($error))
                    <div class="alert alert-danger mt-3" role="alert" style="height: 500px;">
                        {{ $error }}
                        <div class="py-5 bg-image-full"
                            style="background-image: url('images/no_result.gif'); background-size: cover; height: 100vh;">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        var isAscending = true; // Flag to track sorting order
        var isAscendingDate = true; // Flag to track date sorting order
        var isAscendingRating = true; // Flag to track rating sorting order
        var isAscendingPrice = true;

        function showNotification(message) {
            var notification = document.getElementById('notification');
            notification.textContent = message;
            notification.style.display = 'block';

            // Hide the notification after 3 seconds
            setTimeout(function () {
                notification.style.display = 'none';
            }, 3000);
        }

        function sortResultsByState() {
            var sortButton = document.getElementById('sortButton');
            var sortIcon = document.getElementById('sortIcon');
            sortIcon.style.display = 'inline-block';
            sortButton.disabled = true;

            var resultContainers = document.querySelectorAll('.result-container');
            var resultArray = Array.from(resultContainers);

            setTimeout(function () {
                resultArray.sort(function (a, b) {
                    var stateA = a.querySelector('.service-state').textContent.trim().toUpperCase();
                    var stateB = b.querySelector('.service-state').textContent.trim().toUpperCase();
                    return isAscending ? stateA.localeCompare(stateB) : stateB.localeCompare(stateA);
                });

                isAscending = !isAscending;

                var parentContainer = document.querySelector('.card-body');
                while (parentContainer.firstChild) {
                    parentContainer.removeChild(parentContainer.firstChild);
                }

                resultArray.forEach(function (item, index) {
                    parentContainer.appendChild(item);
                    if (index < resultArray.length - 1) {
                        var whitespace = document.createElement('div');
                        whitespace.style.height = '20px';
                        parentContainer.appendChild(whitespace);
                    }
                });

                sortIcon.style.display = 'none';
                sortButton.disabled = false;
                showNotification('Results sorted by state');
            }, 500);
        }

        function sortResultsByDate() {
            var sortByDateButton = document.getElementById('sortByDateButton');
            var sortByDateIcon = document.getElementById('sortByDateIcon');
            sortByDateIcon.style.display = 'inline-block';
            sortByDateButton.disabled = true;

            var resultContainers = document.querySelectorAll('.result-container');
            var resultArray = Array.from(resultContainers);

            setTimeout(function () {
                resultArray.sort(function (a, b) {
                    var dateA = new Date(a.querySelector('.service-date').textContent.trim());
                    var dateB = new Date(b.querySelector('.service-date').textContent.trim());
                    return isAscendingDate ? dateA - dateB : dateB - dateA;
                });

                isAscendingDate = !isAscendingDate;

                var parentContainer = document.querySelector('.card-body');
                while (parentContainer.firstChild) {
                    parentContainer.removeChild(parentContainer.firstChild);
                }

                resultArray.forEach(function (item, index) {
                    parentContainer.appendChild(item);
                    if (index < resultArray.length - 1) {
                        var whitespace = document.createElement('div');
                        whitespace.style.height = '20px';
                        parentContainer.appendChild(whitespace);
                    }
                });

                sortByDateIcon.style.display = 'none';
                sortByDateButton.disabled = false;
                showNotification('Results sorted by date');
            }, 500);
        }

        function sortResultsByRating() {
            var sortByRatingButton = document.getElementById('sortByRatingButton');
            var sortByRatingIcon = document.getElementById('sortByRatingIcon');
            sortByRatingIcon.style.display = 'inline-block';
            sortByRatingButton.disabled = true;

            var resultContainers = document.querySelectorAll('.result-container');
            var resultArray = Array.from(resultContainers);

            setTimeout(function () {
                resultArray.sort(function (a, b) {
                    var ratingStateA = a.querySelector('.rating-state');
                    var ratingStateB = b.querySelector('.rating-state');

                    // Extract ratings
                    var ratingA = extractRatingValue(ratingStateA);
                    var ratingB = extractRatingValue(ratingStateB);

                    return isAscendingRating ? ratingA - ratingB : ratingB - ratingA;
                });

                isAscendingRating = !isAscendingRating;

                var parentContainer = document.querySelector('.card-body');
                while (parentContainer.firstChild) {
                    parentContainer.removeChild(parentContainer.firstChild);
                }

                resultArray.forEach(function (item, index) {
                    parentContainer.appendChild(item);
                    if (index < resultArray.length - 1) {
                        var whitespace = document.createElement('div');
                        whitespace.style.height = '20px';
                        parentContainer.appendChild(whitespace);
                    }
                });

                sortByRatingIcon.style.display = 'none';
                sortByRatingButton.disabled = false;
                showNotification('Results sorted by rating');
            }, 500);
        }

        // Helper function to extract and parse rating value
        function extractRatingValue(ratingStateElement) {
            if (ratingStateElement) {
                var ratingText = ratingStateElement.textContent.trim().split(':')[1].trim();
                var ratingValue = parseInt(ratingText);
                return isNaN(ratingValue) ? 0 : ratingValue; // Default to 0 if parsing fails
            }
            return 0; // Default to 0 if element not found
        }


        function sortResultsByPrice() {
            var sortByPriceButton = document.getElementById('sortByPriceButton');
            var sortByPriceIcon = document.getElementById('sortByPriceIcon');
            sortByPriceIcon.style.display = 'inline-block';
            sortByPriceButton.disabled = true;

            var resultContainers = document.querySelectorAll('.result-container');
            var resultArray = Array.from(resultContainers);

            setTimeout(function () {
                resultArray.sort(function (a, b) {
                    var priceA = parseFloat(a.querySelector('.service-price').textContent.trim().replace(/[^0-9.-]+/g, ""));
                    var priceB = parseFloat(b.querySelector('.service-price').textContent.trim().replace(/[^0-9.-]+/g, ""));
                    return isAscendingPrice ? priceA - priceB : priceB - priceA;
                });

                isAscendingPrice = !isAscendingPrice;

                var parentContainer = document.querySelector('.card-body');
                while (parentContainer.firstChild) {
                    parentContainer.removeChild(parentContainer.firstChild);
                }

                resultArray.forEach(function (item, index) {
                    parentContainer.appendChild(item);
                    if (index < resultArray.length - 1) {
                        var whitespace = document.createElement('div');
                        whitespace.style.height = '20px';
                        parentContainer.appendChild(whitespace);
                    }
                });

                sortByPriceIcon.style.display = 'none';
                sortByPriceButton.disabled = false;
                showNotification('Results sorted by price');
            }, 500);
        }
    </script>

</body>

</html>
@endsection