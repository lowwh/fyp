@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Custom CSS for this section -->
    <style>
        .custom-style {
            padding: 20px;
            background-color: #f8f9fa;
            /* Light background color */
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
    </style>

    <div class="custom-style">
        <div class="gig-id">Gig ID: {{$service_id}}</div>
        <div class="requester-name">Requester Name: {{$biddername}}</div>
        <!-- Trigger button for the modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#biddingModal">
            View Bidding Request
        </button>

        <form method="post" action="">
            <button class="btn btn-primary" type="submit" onclick="confirmSubmission(event)">Confirm

            </button>
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
                        <!-- Your content here -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- Optional: Add any action buttons here -->
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function confirmSubmission(event) {
        if (!confirm('Are you sure you want to confirm?')) {
            event.preventDefault();
        }
    }
</script>