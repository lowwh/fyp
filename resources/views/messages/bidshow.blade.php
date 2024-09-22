@extends('layouts.app')

@section('content')
<div class="container">
    <style>
        .order-custom-style {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* General Progress Bar and Step styles */
        .order-progress-container {
            margin-bottom: 20px;
            position: relative;
            padding-top: 30px;
        }

        .order-progress-bar {
            position: absolute;
            top: 25px;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: #ccc;
            z-index: 1;
        }

        .order-progress-bar-fill {
            position: absolute;
            top: 25px;
            left: 0;
            width: 16.67%;
            height: 4px;
            background-color: #007bff;
            z-index: 2;
            transition: width 0.5s ease;
        }

        .order-progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            z-index: 3;
        }

        .order-progress-step {
            width: 33.33%;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: #6c757d;
            transition: color 0.5s ease;
        }

        .order-progress-step::before {
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

        .order-progress-step.completed {
            color: #007bff;
        }

        .order-progress-step.completed::before {
            background-color: #007bff;
            border-color: #007bff;
        }

        .order-progress-step.current {
            color: #007bff;
        }

        .order-progress-step.current::before {
            background-color: #007bff;
            border-color: #007bff;
        }

        /* Styling for Requester Name */
        .order-requester-name {
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: inline-block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Dropdown menu styling */
        .order-dropdown-menu {
            display: none;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 15px;
            min-width: 250px;
        }

        .order-dropdown-header {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            /* Change color to match primary button */
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 10px;
            text-transform: uppercase;
            /* Make the title uppercase */
            letter-spacing: 1px;
            /* Add spacing for better readability */
            background-color: #f0f4ff;
            /* Light background for contrast */
            padding: 10px;
            /* Add padding for better spacing */
            border-radius: 5px;
            /* Add rounded corners */
        }

        /* Adding hover effect */
        .order-dropdown-menu div:hover {
            background-color: #e0e7ff;
            /* Change hover color for better contrast */
            padding: 5px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        /* Adding hover effect */
        .order-dropdown-menu div:hover {
            background-color: #f8f9fa;
            padding: 5px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        /* Styling the dropdown toggle button */
        .order-dropdown-toggle {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: bold;
            display: flex;
            align-items: center;
            /* Align items vertically */
        }

        .order-dropdown-toggle:hover {
            background-color: #0056b3;
        }

        .order-dropdown-arrow {
            margin-left: 8px;
            /* Space between text and arrow */
        }

        .order-dropdown-arrow.up {
            transform: rotate(180deg);
            /* Rotate arrow upwards */
        }
    </style>

    <div class="order-custom-style">
        <div class="order-requester-name"><i class="fas fa-user"></i> Requester Name: {{ $biddername }}</div>

        <div class="order-progress-container">
            <div class="order-progress-bar"></div>
            <div class="order-progress-bar-fill" id="orderProgressBarFill"></div>
            <div class="order-progress-steps">
                <div class="order-progress-step completed">Step 1: Order Placed</div>
                <div class="order-progress-step" id="step-under-review">Step 2: Under Review</div>
                <div class="order-progress-step" id="step-confirmation">Step 3: Confirmation</div>
            </div>
        </div>

        <div style="border-top: 3px solid #ddd;"></div>

        <div class="button-container">
            <div class="order-dropdown">
                <button class="btn btn-primary order-dropdown-toggle" type="button" id="viewRequestDropdown"
                    aria-haspopup="true" aria-expanded="false" style="margin-top:20px; margin-bottom:20px">
                    View Order Request
                    <span class="order-dropdown-arrow" id="orderDropdownArrow">&#9660;</span> <!-- Downward arrow -->
                </button>
                <div class="order-dropdown-menu" id="orderDropdownMenu" aria-labelledby="viewRequestDropdown">
                    <h6 class="order-dropdown-header">Order Information</h6>
                    <div><strong>Customer Name:</strong> {{ $biddername }}</div>
                    <br>

                    <h6 class="order-dropdown-header">Service Information</h6>
                    <div><strong>Service Title:</strong> {{ $service_title }}</div>
                    <div><strong>Service Price:</strong> {{ $service_price }}</div>
                </div>
            </div>

            <form id="confirmForm" method="post"
                action="/get/progression/{{$service_id}}/{{$freelancer_id}}/{{$bidder_id}}/{{$notification_id}}/{{$user_id}}/{{$service_price}}">
                @csrf
                <button class="btn btn-primary order-dropdown-toggle" type="button" id="confirmButton" disabled
                    style="margin-top:20px">Confirm</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('viewRequestDropdown').addEventListener('click', function () {
        console.log('View Order Request button clicked');

        var orderDropdownMenu = document.getElementById('orderDropdownMenu');
        var orderDropdownArrow = document.getElementById('orderDropdownArrow');
        var isVisible = orderDropdownMenu.style.display === 'block';

        // Toggle the dropdown menu visibility
        orderDropdownMenu.style.display = isVisible ? 'none' : 'block';

        // Toggle the arrow direction
        orderDropdownArrow.classList.toggle('up', !isVisible);

        if (!isVisible) {
            var stepUnderReview = document.getElementById('step-under-review');
            stepUnderReview.classList.add('completed', 'current');

            // Update progress bar width to 50%
            var orderProgressBarFill = document.getElementById('orderProgressBarFill');
            orderProgressBarFill.style.width = '50%';

            // Enable the confirm button
            var confirmButton = document.getElementById('confirmButton');
            confirmButton.disabled = false;
            confirmButton.classList.remove('btn-secondary');
            confirmButton.classList.add('btn-primary');
        }
    });

    document.getElementById('confirmButton').addEventListener('click', function (e) {
        e.preventDefault();
        console.log('Confirm button clicked');

        this.disabled = true;

        var orderProgressBarFill = document.getElementById('orderProgressBarFill');
        orderProgressBarFill.style.width = '100%';

        var stepUnderReview = document.getElementById('step-under-review');
        stepUnderReview.classList.remove('current');

        var stepConfirmation = document.getElementById('step-confirmation');
        stepConfirmation.classList.add('completed');

        setTimeout(function () {
            document.getElementById('confirmForm').submit();
        }, 600); // Match transition time
    });
</script>

@endsection