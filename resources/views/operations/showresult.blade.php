@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* Custom CSS for styling */
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
            max-width: 2000px;
            /* Adjust as needed */
        }

        .input-group {
            margin-bottom: 20px;

        }

        .sort-buttons {
            background-color: white;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }

        .sort-buttons button {
            flex: 1;
            position: relative;
        }

        .sort-buttons .loading-icon {
            display: none;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .main-content {
            display: flex;
            gap: 20px;
            max-width: 1600px;

        }

        .results-container {
            flex: 1;
            max-width: 1000px;
            /* Ensures results container takes remaining space */
        }

        .result-item {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .result-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .result-item .profile-image img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .result-item h5 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .result-item p {
            margin: 5px 0;
        }

        .no-results-found img {
            max-width: 1000px;
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .print-button {
            margin-top: 20px;
        }

        .chatgpt-wrapper {
            position: sticky;
            right: 0;
            top: 0;
            width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            padding: 15px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            border-radius: 8px;
            font-family: 'Arial', sans-serif;
            /* Choose a clean, readable font */
            font-size: 16px;
            /* Set a readable font size */
            font-weight: 400;
            /* Use a normal font weight */
            line-height: 1.5;
            /* Improve line spacing */
            color: #333;

            margin-left: 100px
        }

        .profile-image {
            margin-left: 100px;
        }

        .form-control:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media screen and (max-width: 1200px) {
            .chatgpt-wrapper {
                position: relative;
                width: 100%;
            }
        }

        button.btn:hover .sendQuestionButton {
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }

        .service-image img {
            border-radius: .5rem;
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="{{ route('search.result') }}">
            @csrf
            <div class="input-group" style="max-width: 800px; margin: auto; margin-bottom:20px">
                <input type="text" id="servicetype" name="servicetype" class="form-control"
                    placeholder="Enter Service Type" aria-label="Enter Service Type" aria-describedby="searchButton"
                    style="padding: 16px; font-size: 18px; height: 60px; border-radius: 8px; box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);">
                <button class="btn btn-primary" type="submit" id="searchButton"
                    style="padding: 16px 30px; font-size: 18px; height: 60px; border-radius: 8px;">
                    Search
                </button>
            </div>
        </form>


        <div class="sort-buttons">
            <button id="sortByDateButton" class="btn btn-primary" onclick="sortResultsByDate()">
                Sort by Date
                <i id="sortByDateIcon" class="fas fa-spinner fa-spin" style="display: none;"></i>
            </button>
            <button id="sortButton" class="btn btn-primary" onclick="sortResultsByState()">
                Sort by State
                <i id="sortIcon" class="fas fa-spinner fa-spin" style="display: none;"></i>
            </button>
            <button id="sortByRatingButton" class="btn btn-primary" onclick="sortResultsByRating()">
                Sort by Rating
                <i id="sortByRatingIcon" class="fas fa-spinner fa-spin" style="display: none;"></i>
            </button>
            <button id="sortByPriceButton" class="btn btn-primary" onclick="sortResultsByPrice()">
                Sort by Price
                <i id="sortByPriceIcon" class="fas fa-spinner fa-spin" style="display: none;"></i>
            </button>
        </div>

        <div class="main-content">
            <div class="results-container">
                @if(isset($results) && !$results->isEmpty())
                    @foreach($results as $result)
                        <div class="result-item">
                            <div class="row">
                                <div class="col-md-4">
                                    @if($result->serviceimage)
                                        <div class="service-image"><img src="{{ asset('storage/' . $result->serviceimage) }}"
                                                alt="Service Image"></div>

                                    @else
                                        <img src="{{ asset('images/noimage.jfif') }}" alt="No Service Image">
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    @if($result->image_path)
                                        <div class="profile-image">
                                            <img src="{{ asset('storage/' . $result->image_path) }}" alt="Profile Image">
                                        </div>
                                    @else
                                        <div class="profile-image">
                                            <img src="{{ asset('images/default_profile_image.png') }}" alt="Default Profile Image">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h5>{{ $result->title }}</h5>
                                    <p><strong>Service State:</strong> <span class="service-state">{{ $result->state }}</span>
                                    </p>
                                    <p><strong>Service Price:</strong> <span class="service-price">{{ $result->price }}</span>
                                    </p>
                                    <p><strong>Total Rating:</strong> <span
                                            class="rating-state">{{ $result->gigs_count > 0 ? $result->gigs_count : '0' }}</span>
                                    </p>
                                    <p><strong>Posted On:</strong> <span
                                            class="service-date">{{ $result->service_created_date }}</span></p>
                                    <a href="/viewservice/{{ $result->userid }}/{{ $result->serviceid }}"
                                        class="btn btn-secondary">View</a>
                                    <a href="/viewprofile/{{ $result->userid }}" class="btn btn-primary">View Profile</a>
                                    <a href="{{ route('messages.create', $result->userid) }}" class="btn btn-success">Send
                                        Message</a>
                                </div>
                            </div>
                        </div>

                    @endforeach
                    <div class="text-center print-button">
                        <button class="btn btn-primary" onclick="window.print()">Print</button>
                    </div>


                @elseif(isset($error))
                    <div class="no-results-found text-center">
                        <img src="{{ asset('images/noresult.png') }}" alt="No Results Found">
                    </div>
                @endif
            </div>

            <div class="chatgpt-wrapper"
                style="  position: sticky;padding: 30px; background-color: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); max-width: 2500px;">
                @if(isset($results))
                    <h2 style="font-size: 28px; font-weight: 600; color: #333; margin-bottom: 25px;">
                        Analysis
                        <i id="analysisLoadingIcon" class="fas fa-spinner fa-spin"
                            style="display: none; margin-left: 10px; color: #007bff; font-size: 18px;"></i>
                    </h2>

                    <div style="display: flex; align-items: center; margin-bottom: 20px;">
                        <input id="questionInput" type="text" placeholder="Enter your question" name="question"
                            style="flex-grow: 1; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05); margin-right: 15px; transition: border-color 0.3s;">
                        <button id="sendQuestionButton" type="button" class="btn btn-primary"
                            style="padding: 12px 30px; border: none; background-color: #007bff; color: #fff; border-radius: 6px; cursor: pointer; font-size: 16px; transition: background-color 0.3s, box-shadow 0.3s;">
                            Submit
                        </button>
                    </div>

                    <div id="chatgpt" data-results="{{ json_encode($results) }}"></div>
                    <div id="react-root"></div> <!-- Placeholder for React component -->
                @endif
            </div>


        </div>
    </div>

    <script>
        var isAscending = true; // Flag to track sorting order
        var isAscendingDate = true; // Flag to track date sorting order
        var isAscendingRating = true; // Flag to track rating sorting order
        var isAscendingPrice = true; // Flag to track price sorting order

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

            var resultContainers = document.querySelectorAll('.result-item');
            var resultArray = Array.from(resultContainers);

            setTimeout(function () {
                resultArray.sort(function (a, b) {
                    var stateA = a.querySelector('.service-state').textContent.trim().toUpperCase();
                    var stateB = b.querySelector('.service-state').textContent.trim().toUpperCase();
                    return isAscending ? stateA.localeCompare(stateB) : stateB.localeCompare(stateA);
                });

                isAscending = !isAscending;

                var parentContainer = document.querySelector('.results-container');
                resultArray.forEach(function (item) {
                    parentContainer.appendChild(item);
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

            var resultContainers = document.querySelectorAll('.result-item');
            var resultArray = Array.from(resultContainers);

            setTimeout(function () {
                resultArray.sort(function (a, b) {
                    var dateA = new Date(a.querySelector('.service-date').textContent.trim());
                    var dateB = new Date(b.querySelector('.service-date').textContent.trim());
                    return isAscendingDate ? dateA - dateB : dateB - dateA;
                });

                isAscendingDate = !isAscendingDate;

                var parentContainer = document.querySelector('.results-container');
                resultArray.forEach(function (item) {
                    parentContainer.appendChild(item);
                });

                sortByDateIcon.style.display = 'none';
                sortByDateButton.disabled = false;
                showNotification('Results sorted by date');
            }, 500);
        }

        function sortResultsByRating() {
            var sortByRatingButton = document.getElementById('sortByRatingButton');
            var sortByRatingIcon = document.getElementById('sortByRatingIcon');

            // Show the loading icon and disable the button
            sortByRatingIcon.style.display = 'inline-block';
            sortByRatingButton.disabled = true;

            // Get all result items
            var resultContainers = Array.from(document.getElementsByClassName('result-item'));

            // Sort the items by rating
            resultContainers.sort(function (a, b) {
                var ratingA = parseFloat(a.querySelector('.rating-state').textContent.trim()) || 0;
                var ratingB = parseFloat(b.querySelector('.rating-state').textContent.trim()) || 0;
                return isAscendingRating ? ratingA - ratingB : ratingB - ratingA;
            });

            // Append sorted items back to the container
            var parentContainer = document.querySelector('.results-container');
            resultContainers.forEach(function (container) {
                parentContainer.appendChild(container);
            });

            // Toggle sorting order
            isAscendingRating = !isAscendingRating;

            // Hide the loading icon and enable the button
            setTimeout(function () {
                sortByRatingIcon.style.display = 'none';
                sortByRatingButton.disabled = false;
            }, 300); // You can adjust the delay as needed

            // Show notification for the sorting action
            showNotification("Results sorted by rating.");
        }




        function sortResultsByPrice() {
            var sortByPriceButton = document.getElementById('sortByPriceButton');
            var sortByPriceIcon = document.getElementById('sortByPriceIcon');
            sortByPriceIcon.style.display = 'inline-block';
            sortByPriceButton.disabled = true;

            var resultContainers = document.querySelectorAll('.result-item');
            var resultArray = Array.from(resultContainers);

            setTimeout(function () {
                resultArray.sort(function (a, b) {
                    var priceA = parseFloat(a.querySelector('.service-price').textContent.trim().replace(/[^0-9.-]+/g, ""));
                    var priceB = parseFloat(b.querySelector('.service-price').textContent.trim().replace(/[^0-9.-]+/g, ""));
                    return isAscendingPrice ? priceA - priceB : priceB - priceA;
                });

                isAscendingPrice = !isAscendingPrice;

                var parentContainer = document.querySelector('.results-container');
                resultArray.forEach(function (item) {
                    parentContainer.appendChild(item);
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