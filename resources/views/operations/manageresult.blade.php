@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="nav-icon fas fa-cog  "></i> Progress </li>
                        <li class="breadcrumb-item active"><i class="fas fa-sync  nav-iconn"></i> Manage Progress
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Freelancer ID</th>
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $previousFreelancerId = null;
                                    $uniqueFreelancerIds = [];
                                @endphp

                                @foreach ($results as $result)
                                                        @can('view', $result)
                                                                                @if (!in_array($result->freelancer_id, $uniqueFreelancerIds))
                                                                                                        @php
                                                                                                            $uniqueFreelancerIds[] = $result->freelancer_id;
                                                                                                        @endphp
                                                                                                        <tr>

                                                                                                            <td>{{ $result->freelancer_id }}</td>
                                                                                                            <td>{{ $result->name }}</td>
                                                                                                            <td>
                                                                                                                <button class="btn btn-info show-more"
                                                                                                                    data-student-id="{{ $result->freelancer_id }}">Show More</button>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr class="additional-row d-none" data-student-id="{{ $result->freelancer_id }}">
                                                                                                            <td colspan="4">
                                                                                                                <table class="table table-bordered">
                                                                                                                    <thead>
                                                                                                                        <tr>
                                                                                                                            <th>Gig Id</th>
                                                                                                                            <th>Progress Bar</th>
                                                                                                                            @can('isFreelancer')
                                                                                                                                <th>Actions</th>
                                                                                                                            @endcan
                                                                                                                        </tr>
                                                                                                                    </thead>
                                                                                                                    <tbody>

                                                                                                                        @foreach ($results as $innerResult)
                                                                                                                            @can('view', $innerResult)
                                                                                                                                @if ($innerResult->freelancer_id === $result->freelancer_id)
                                                                                                                                    <tr>
                                                                                                                                        <td>{{ $innerResult->gig_id }}</td>
                                                                                                                                        <td>
                                                                                                                                            <div class="progress">
                                                                                                                                                <div class="progress-bar" role="progressbar"
                                                                                                                                                    style="width: {{ $innerResult->progress }}%;"
                                                                                                                                                    aria-valuenow="{{ $innerResult->progress }}"
                                                                                                                                                    aria-valuemin="0" aria-valuemax="100">
                                                                                                                                                    {{ $innerResult->progress }}%
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            <span class="result-score"></span>
                                                                                                                                            <form class="update-form d-none"
                                                                                                                                                action="{{ route('result.update', $innerResult->id) }}"
                                                                                                                                                method="POST" style="display: inline;">
                                                                                                                                                @csrf
                                                                                                                                                <input type="text" name="progress"
                                                                                                                                                    value="{{ $innerResult->progress }}">
                                                                                                                                                <button type="submit" class="btn btn-primary">Save</button>
                                                                                                                                            </form>
                                                                                                                                        </td>
                                                                                                                                        <td>
                                                                                                                                            @can('isFreelancer')
                                                                                                                                                <button class="btn btn-primary update-btn">Update</button>
                                                                                                                                            @endcan
                                                                                                                                            <form class="delete-form"
                                                                                                                                                action="{{ route('result.delete', $innerResult->id) }}"
                                                                                                                                                method="GET" style="display: inline;">
                                                                                                                                                @csrf
                                                                                                                                                @can('isFreelancer')
                                                                                                                                                    <button type="submit"
                                                                                                                                                        class="btn btn-danger delete-btn">Delete</button>
                                                                                                                                                @endcan
                                                                                                                                            </form>
                                                                                                                                            @can('isUser')
                                                                                                                                                @if($innerResult->progress == 100.00)
                                                                                                                                                    <form action="/historygig/{{$result->serviceid}}" method="get">
                                                                                                                                                        <button type="submit"
                                                                                                                                                            class="btn btn-success btn-sm">Done</button>
                                                                                                                                                    </form>

                                                                                                                                                @endif
                                                                                                                                            @endcan

                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                @endif
                                                                                                                            @endcan
                                                                                                                        @endforeach
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                @endif
                                                        @endcan
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for handling show more functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Attach click event listener to show more buttons
        document.querySelectorAll('.show-more').forEach(function (button) {
            button.addEventListener('click', function () {
                var studentId = this.dataset.studentId; // Get the student_id from the button's data attribute
                var additionalRows = document.querySelectorAll('.additional-row[data-student-id="' + studentId + '"]');
                var currentButtonRow = this.closest('tr');

                // Hide all other additional rows and show only the clicked one
                document.querySelectorAll('.additional-row').forEach(function (row) {
                    if (row.dataset.studentId !== studentId) {
                        row.classList.add('d-none');
                    }
                });

                // Toggle the display of additional rows for the specific student only
                additionalRows.forEach(function (row) {
                    row.classList.toggle('d-none');
                });
            });
        });

        // Attach click event listener to update buttons
        document.querySelectorAll('.update-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                var row = this.closest('tr');
                row.querySelector('.progress').classList.add('d-none'); // Hide result score
                row.querySelector('.update-form').classList.remove('d-none'); // Show update form
            });
        });
    });
</script>
@endsection