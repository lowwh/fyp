@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Custom CSS for this section -->
    <style>
        .custom-style {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .custom-style .gig-id,
        .custom-style .requester-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .custom-style .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .progress-container {
            margin-bottom: 20px;
        }

        .progress-step {
            width: 33.33%;
            text-align: center;
            font-weight: bold;
            color: #007bff;
            /* Default color */
        }

        .progress-step.completed {
            color: green;
            /* Completed status color */
        }
    </style>

    <div class="custom-style">
        <div class="gig-id">Gig ID: {{ $service_id }}</div>
        <div class="requester-name">Requester Name: {{ $biddername }}</div>
        <!-- Progress Indicator -->
        <div class="progress-container">
            <div class="d-flex">
                <div class="progress-step completed">Step 1: Bid Placed</div>
                <div class="progress-step {{ $status === 'completed' ? 'completed' : '' }}" id="step-under-review">Step
                    2:
                    Under Review</div>
                <div class="progress-step {{ $status === 'completed' ? 'completed' : '' }}" id="step-confirmation">Step
                    3: Confirmation</div>
            </div>
        </div>
        <!-- Trigger button for the modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#biddingModal"
            id="viewRequestButton">
            View Bidding Request
        </button>
        <br><br>
        <form method="post"
            action="/get/progression/{{$service_id}}/{{$freelancer_id}}/{{$bidder_id}}/{{$notification_id}}/{{$user_id}}">
            @csrf
            <button class="btn btn-primary" type="submit" id="confirmButton" disabled>Confirm</button>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="biddingModal" tabindex="-1" aria-labelledby="biddingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="biddingModalLabel">Bidding Request from {{ $biddername }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Modal body content -->
                <div class="card">
                    <div class="card-body">
                        <!-- Bidding Request Details -->
                        <div class="info-item">
                            <i class="fas fa-user icon"></i>
                            <span>Bidder Name: {{ $biddername }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-id-badge icon"></i>
                            <span>Service ID: {{ $service_id }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar icon"></i>
                            <span>Requested On: {{ now()->format('Y-m-d') }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-info-circle icon"></i>
                            <span>Additional Info: [Your additional info here]</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('viewRequestButton').addEventListener('click', function () {
        document.getElementById('step-under-review').classList.add('completed');
        document.getElementById('confirmButton').disabled = false;
    });
</script>
@endsection