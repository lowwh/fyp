@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="nav-icon fas fa-user-graduate"></i> Result </li>
                        <li class="breadcrumb-item active"><i class="fas fa-user-friends nav-iconn"></i> Manage Result</li>
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
                                    <th>ID</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $previousStudentId = null;
                                @endphp
                                @php
                                    $uniqueStudentIds = []; // Array to store unique student IDs
                                @endphp

                                @foreach ($results as $result)
                                    @if (!in_array($result->student_id, $uniqueStudentIds)) <!-- Check if student ID is not already processed -->
                                        @php
                                            $uniqueStudentIds[] = $result->student_id; // Add student ID to the array of unique student IDs
                                        @endphp
                                        <tr>
                                            <td>{{ $result->id }}</td>
                                            <td>{{ $result->student_id }}</td>
                                            <td>{{ $result->name }}</td>
                                            <td>
                                                <button class="btn btn-info show-more" data-student-id="{{ $result->student_id }}">Show More</button>
                                            </td>
                                        </tr>
                                        <tr class="additional-row d-none" data-student-id="{{ $result->student_id }}">
                                            <td colspan="4">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Course</th>
                                                            <th>Result Score</th>
                                                            <th>Actions</th> <!-- New column for actions -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($results as $innerResult)
                                                            @if ($innerResult->student_id === $result->student_id)
                                                                <tr>
                                                                    <td>{{ $innerResult->id }}</td>
                                                                    <td>{{ $innerResult->course }}</td>
                                                                    <td>
                                                                        <span class="result-score">{{ $innerResult->result_score }}</span> <!-- Display result score -->
                                                                        <form class="update-form d-none" action="{{ route('result.update', $innerResult->id) }}" method="POST" style="display: inline;">
                                                                            @csrf
                                                                            <input type="text" name="result_score" value="{{ $innerResult->result_score }}">
                                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-warning btn-sm mr-1">Update</button> <!-- Update button -->
                                                                        <form class="delete-form" action="{{ route('result.delete', $innerResult->id) }}" method="GET" style="display: inline;">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button> <!-- Delete button -->
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    @endif
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
    // Wait for the document to be ready
    document.addEventListener('DOMContentLoaded', function () {
        // Attach click event listener to show more buttons
        document.querySelectorAll('.show-more').forEach(function(button) {
            button.addEventListener('click', function() {
                var studentId = this.dataset.studentId; // Get the student_id from the button's data attribute
                var additionalRows = document.querySelectorAll('.additional-row[data-student-id="' + studentId + '"]');
                var currentButtonRow = this.closest('tr');

                // Hide all other additional rows and show only the clicked one
                document.querySelectorAll('.additional-row').forEach(function(row) {
                    if (row.dataset.studentId !== studentId) {
                        row.classList.add('d-none');
                    }
                });

                // Toggle the display of additional rows for the specific student only
                additionalRows.forEach(function(row) {
                    row.classList.toggle('d-none');
                });
            });
        });

        // Attach click event listener to update buttons
        document.querySelectorAll('.update-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var row = this.closest('tr');
                row.querySelector('.result-score').classList.add('d-none'); // Hide result score
                row.querySelector('.update-form').classList.remove('d-none'); // Show update form
            });
        });
    });
</script>
@endsection
