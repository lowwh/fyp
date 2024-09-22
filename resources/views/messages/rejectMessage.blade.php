@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center display-4">Rejection Details</h1>

    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Rejection Details</h5>
        </div>
        <div class="card-body">

            <div class="mb-3 border p-4 rounded shadow-sm bg-light">
                <p class="h5 text-muted"><strong>Reason:</strong> {{ $rejection->reason }}</p>
                <p class="h5 text-muted"><strong>Submitted By:</strong> {{ $rejection->name }}</p>

                <span
                    class="status-label {{ $rejection->status === 'Pending' ? 'pending' : ($rejection->status === 'Rejected' ? 'rejected' : '') }}">
                    {{ $rejection->status }}
                </span>
                <br><br>

                <p class="h5 text-muted">
                    <strong>Sent:</strong> {{ \Carbon\Carbon::parse($rejection->created_at)->diffForHumans() }}
                </p>
            </div>

        </div>
    </div>

    <hr class="my-4">
    <div class="text-center"></div>
</div>

<style>
    .card {
        border: none;
        /* Remove the default border */
        border-radius: 10px;
        /* Rounded corners for the card */
    }

    .card-header {
        border-radius: 10px 10px 0 0;
        /* Rounded corners for the header */
    }

    .text-muted {
        font-size: 1.25rem;
        color: #6c757d;
        /* Bootstrap's muted color */
    }

    .status-label {
        padding: 8px 12px;
        border-radius: 20px;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        /* Uppercase text for status */
        letter-spacing: 0.5px;
        /* Slight letter spacing */
        display: inline-block;
        /* Ensure proper spacing */
    }

    /* Background color based on status */
    .status-label {
        background-color: #28a745;
        /* Green for success */
    }

    .status-label.pending {
        background-color: #ffc107;
        /* Yellow for pending */
    }

    .status-label.rejected {
        background-color: #dc3545;
        /* Red for rejected */
    }

    /* Adding some padding and a subtle shadow to the card body */
    .card-body {
        padding: 2rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Light background for better contrast */
    .bg-light {
        background-color: #f8f9fa;
        /* Bootstrap light color */
    }
</style>

<script>
    // Optional: Add JavaScript for additional interactivity if needed
</script>
@endsection