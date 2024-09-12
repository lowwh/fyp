@extends('layouts.app')

@section('content')
<div class="container">
    <style>
        .custom-style {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .progress-container {
            margin-bottom: 20px;
            position: relative;
            padding-top: 30px;
        }

        .progress-bar {
            position: absolute;
            top: 25px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #ccc;
            z-index: 1;
        }

        .progress-bar-fill {
            position: absolute;
            top: 25px;
            left: 0;
            width: 16.67%;
            height: 2px;
            background-color: #007bff;
            z-index: 2;
            transition: width 0.5s ease;
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            z-index: 3;
        }

        .progress-step {
            width: 33.33%;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: #6c757d;
            transition: color 0.5s ease;
        }

        .progress-step::before {
            content: '';
            display: block;
            width: 12px;
            height: 12px;
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 50%;
            margin: 0 auto 8px;
            transition: background-color 0.5s ease, border-color 0.5s ease;
        }

        .progress-step.completed {
            color: #007bff;
        }

        .progress-step.completed::before {
            background-color: #007bff;
            border-color: #007bff;
        }

        .progress-step.current {
            color: #007bff;
        }

        .progress-step.current::before {
            background-color: #fff;
            border-color: #007bff;
        }

        .button-container {
            margin-top: 20px;
        }

        .button-container .btn {
            margin-right: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }
    </style>

    <div class="custom-style">
        <div class="gig-id">Gig ID: {{ $service_id }}</div>
        <div class="requester-name">Requester Name: {{ $biddername }}</div>

        <div class="progress-container">
            <div class="progress-bar"></div>
            <div class="progress-bar-fill" id="progressBarFill"></div>
            <div class="progress-steps">
                <div class="progress-step completed">Step 1: Bid Placed</div>
                <div class="progress-step" id="step-under-review">Step 2: Under Review</div>
                <div class="progress-step" id="step-confirmation">Step 3: Confirmation</div>
            </div>
        </div>

        <div style="border-top: 1px solid #ddd;"></div>

        <div class="button-container">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="viewRequestDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    View Bidding Request
                </button>
                <div class="dropdown-menu" aria-labelledby="viewRequestDropdown">
                    <div>Bidder Name: {{ $biddername }}</div>
                    <div>Service ID: {{ $service_id }}</div>
                </div>
            </div>

            <form id="confirmForm" method="post"
                action="/get/progression/{{$service_id}}/{{$freelancer_id}}/{{$bidder_id}}/{{$notification_id}}/{{$user_id}}">
                @csrf
                <button class="btn btn-secondary" type="button" id="confirmButton" disabled>Confirm</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('viewRequestDropdown').addEventListener('click', function () {
        console.log('View Bidding Request button clicked');

        var stepUnderReview = document.getElementById('step-under-review');
        console.log('stepUnderReview before:', stepUnderReview.classList);

        // Add classes to update the second step
        stepUnderReview.classList.add('completed', 'current');
        console.log('stepUnderReview after:', stepUnderReview.classList);

        // Update progress bar width to 50%
        var progressBarFill = document.getElementById('progressBarFill');
        progressBarFill.style.width = '50%';
        console.log('Progress bar width updated to 50%');

        // Enable the confirm button
        var confirmButton = document.getElementById('confirmButton');
        confirmButton.disabled = false;
        confirmButton.classList.remove('btn-secondary');
        confirmButton.classList.add('btn-primary');
        console.log('Confirm button enabled');
    });

    document.getElementById('confirmButton').addEventListener('click', function (e) {
        e.preventDefault();
        console.log('Confirm button clicked');

        this.disabled = true;

        var progressBarFill = document.getElementById('progressBarFill');
        progressBarFill.style.width = '100%';
        console.log('Progress bar width updated to 100%');

        var stepUnderReview = document.getElementById('step-under-review');
        stepUnderReview.classList.remove('current');

        var stepConfirmation = document.getElementById('step-confirmation');
        stepConfirmation.classList.add('completed');
        console.log('Step confirmation marked as completed');

        setTimeout(function () {
            document.getElementById('confirmForm').submit();
        }, 600); // Match transition time
    });
</script>
@endsection