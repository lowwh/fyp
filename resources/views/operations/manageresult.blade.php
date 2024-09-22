@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><i class="nav-icon fas fa-cog"></i> Progress</li>
                        <li class="breadcrumb-item active"><i class="fas fa-sync nav-iconn"></i> Manage Progress</li>
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
                        <div class="flex-container">
                            @can('isUser')
                                <div class="stat-card">
                                    <h3>Total Service</h3>
                                    <p>{{ $totalUsers }}</p>
                                </div>
                                <div class="stat-card">
                                    <h3>Completed Service</h3>
                                    <p>{{ $usercompletedProjects }}</p>
                                </div>
                                <div class="stat-card">
                                    <h3>Pending Service</h3>
                                    <p>{{ $userpendingProjects }}</p>
                                </div>
                                <div class="stat-card">
                                    <h3>Rejected Service</h3>
                                    <p>{{ $userrejectedProjects }}</p>
                                </div>
                            @endcan

                            @can('isFreelancer')
                                <div class="stat-card">
                                    <h3>Total Service</h3>
                                    <p>{{ $totalUsers }}</p>
                                </div>
                                <div class="stat-card">
                                    <h3>Completed Service</h3>
                                    <p>{{ $freelancercompletedProjects }}</p>
                                </div>
                                <div class="stat-card">
                                    <h3>Pending Service</h3>
                                    <p>{{ $freelancerpendingProjects }}</p>
                                </div>
                                <div class="stat-card">
                                    <h3>Rejected Service</h3>
                                    <p>{{ $freelancerrejectedProjects }}</p>
                                </div>
                            @endcan
                        </div>

                        <div class="flex-container">
                            <form method="get" action="{{ route('project-summary') }}">
                                <button type="submit" class="btn btn-primary">Show Graph</button>
                            </form>
                        </div>

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
														data-student-id="{{ $result->freelancer_id }}">
														Show More
													</button>
												</td>
											</tr>
											
											 @php
												// Flag to check if the freelancer has any matching results
												$hasNestedResults = false;
											@endphp

											<!-- Check for any innerResult that matches the freelancer_id -->
											@foreach ($results as $innerResult)
												@if ($innerResult->freelancer_id === $result->freelancer_id)
													@php
														$hasNestedResults = true;
													@endphp
													@break
												@endif
											@endforeach
										 @if ($hasNestedResults)

										<tr class="additional-row d-none" data-student-id="{{ $result->freelancer_id }}">
											<td colspan="7">
												<table class="table table-bordered nested-table">
													<thead>
														<tr>
															<th>Service Title</th>
															<th>Customer Name</th>
															<th>Progress Bar</th>
															<th>Progress</th>
															<th>Current Date</th>
															<th>Deadline</th>
															<th>Actions</th>
														</tr>
													</thead>
													<tbody>

										
														@foreach ($results as $innerResult)
															

															@can('view', $innerResult)
																@if ($innerResult->freelancer_id === $result->freelancer_id)
																	<tr>

																		<td>{{ $innerResult->title }}</td>
																		<td>{{ $innerResult->biddername }}</td>

																		<td>
																			<div class="progress">
																				<div class="progress-bar" role="progressbar"
																					style="width: {{ $innerResult->progress }}%"
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
																				@if($innerResult->status === 'Pending')
																					<span class="text-pending">Pending</span>
																				@elseif($innerResult->status === 'Rejected')
																					<span class="text-rejected">Rejected</span>
																				@endif

																				@if($innerResult->progress == 100.00 && $innerResult->exists)
																					<span class="text-success">{{ $innerResult->status }}</span>
																				@endif

																			@endcan

																			@can('isUser')
																				@if($innerResult->status === 'Pending')
																					<span class="text-pending">Pending</span>
																				@elseif($innerResult->status === 'Rejected')
																					<span class="text-rejected">Rejected</span>
																				@endif

																				@if ($innerResult->progress == 100.00 && $innerResult->exists)
																					<span class="text-success">{{ $innerResult->status }}</span>
																				@endif

																			@endcan
																		</td>
																		<td class="text-success">{{ date('Y-m-d') }}</td>
																		<td class="estimate-date">
																			@php

																				$currentdate = date('Y-m-d')

																			@endphp

																			@if($innerResult->estimate_delivery_date)
																				@if($innerResult->estimate_delivery_date >= $currentdate)

																					<span
																						class="text-success">{{ $innerResult->estimate_delivery_date }}</span>

																				@elseif($innerResult->estimate_delivery_date < $currentdate)
																					<span
																						class="text-danger">{{ $innerResult->estimate_delivery_date }}
																						- Late</span>
																				@endif

																			@else
																				<span class="text-success">-</span>
																			@endif


																			<br><br>
																			@can('isUser')
																				<form action="update/deliveryDate/{{$innerResult->resultid}}"
																					method="post">
																					@csrf
																					<input type="date" id="estimatedDeliveryDate"
																						name="estimatedDeliveryDate" class="form-control">
																					<button class='btn-primary' type="submit">Update</button>

																				</form>

																			@endcan
																		</td>
																		<td>
																			@can('isFreelancer')
																				@if($innerResult->status === 'Pending' || $innerResult->status === 'Rejected')
																					<div class="flex-container">
																						<button class="btn btn-primary update-btn">Update</button>
																						<form class="delete-form"
																							action="{{ route('result.delete', $innerResult->id) }}"
																							method="GET" style="display: inline;"
																							onsubmit="confirmDelete()">
																							@csrf
																							<button type="submit"
																								class="btn btn-danger delete-btn">Delete</button>
																						</form>
																						</class>
																						<div>
																				@endif

																			@endcan

																			@can('isUser')
																				@if($innerResult->progress === '100.00' && ($innerResult->status === 'Pending' || $innerResult->status === 'Rejected'))
																					<div class="flex-container">
																						<form
																							action="/showrating/{{ $innerResult->resultid }}/{{ $innerResult->userid }}"
																							method="get">
																							<button type="submit"
																								class="btn btn-success btn-sm flex-item">Done</button>
																						</form>

																					</div>
																				@endif

																				@if($innerResult->status === 'Pending' || $innerResult->status === 'Rejected')
																					<div class="flex-container">

																						<form id="rejectForm"
																							action="{{ route('reject-progress', ['resultid' => $innerResult->resultid, 'userid' => $innerResult->userid]) }}"
																							method="GET">
																							@csrf
																							<button type="button"
																								class="btn btn-danger btn-sm flex-item"
																								data-toggle="modal"
																								data-target="#rejectModal">
																								Reject
																							</button>
																						</form>

																					</div>
																					<!-- Modal -->
																					<div class="modal fade" id="rejectModal" tabindex="-1"
																						role="dialog" aria-labelledby="rejectModalLabel"
																						aria-hidden="true">
																						<div class="modal-dialog" role="document">
																							<div class="modal-content">
																								<div class="modal-header">
																									<h5 class="modal-title"
																										id="rejectModalLabel">Reject Reason
																									</h5>
																									<button type="button" class="close"
																										data-dismiss="modal"
																										aria-label="Close">
																										<span
																											aria-hidden="true">&times;</span>
																									</button>
																								</div>
																								<div class="modal-body">
																									<textarea id="rejectReason"
																										class="form-control"
																										placeholder="Enter your reason here..."
																										rows="3"></textarea>
																								</div>
																								<div class="modal-footer">
																									<button type="button"
																										class="btn btn-secondary"
																										data-dismiss="modal">Close</button>
																									<button type="button"
																										class="btn btn-danger"
																										onclick="submitReject()">Reject</button>
																								</div>
																							</div>
																						</div>
																					</div>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.show-more').forEach(function (button) {
            button.addEventListener('click', function () {
                var studentId = this.dataset.studentId;
                var additionalRows = document.querySelectorAll('.additional-row[data-student-id="' + studentId + '"]');
                document.querySelectorAll('.additional-row').forEach(function (row) {
                    if (row.dataset.studentId !== studentId) {
                        row.classList.add('d-none');
                    }
                });
                additionalRows.forEach(function (row) {
                    row.classList.toggle('d-none');
                });
            });
        });

        document.querySelectorAll('.update-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                var row = this.closest('tr');
                row.querySelector('.progress').classList.add('d-none');
                row.querySelector('.update-form').classList.remove('d-none');
            });
        });
    });
    function confirmDelete() {
        return confirm('Are you sure you want to delete this item? This action cannot be undone.');
    };

    function submitReject() {
        const reason = document.getElementById('rejectReason').value;

        if (!reason) {
            alert('Please provide a reason for rejection.');
            return;
        }

        // Redirect to the reject-progress route with the reason as a query parameter
        const formAction = document.getElementById('rejectForm').action;
        const resultid = '{{ $innerResult->resultid }}'; // Make sure to include the right variable
        const userid = '{{ $innerResult->userid }}'; // Make sure to include the right variable

        window.location.href = `${formAction}?reason=${encodeURIComponent(reason)}`;

        // Hide the modal
        $('#rejectModal').modal('hide');
    }
    function confirmReject() {
        return confirm('Are you sure you want to reject this service? This action cannot be undone.');
    };
</script>



<style>
    .card-body {
        /* Adjust width as needed */
        width: 100%;
        /* Ensures it takes the full width of the parent */
        max-width: 2800px;
        /* Sets a maximum width, adjust as necessary */
        margin: 0 auto;
        /* Centers the card-body within its parent */
    }

    .container {
        max-width: 4500px;
        /* Optional: Ensures the container doesn't exceed the max-width */
        margin: 0 auto;
        /* Centers the container */
    }

    /* Optional: Adjust margins for rows to give extra space */
    .row {
        margin-right: 0;
        margin-left: 0;
    }

    /* Make sure the table takes up full width */
    .table {
        width: 100%;
        font-size: 20px;
    }

    /* Style for the outer table */
    .table th,
    .table td {
        width: auto;
        /* Reset width for outer table */
    }

    /* Style for the nested table */
    .nested-table th,
    .nested-table td {
        width: 150px;
        font-size: 30px;
        /* Set width for all columns */
    }

    .nested-table th:nth-child(1),
    .nested-table td:nth-child(1) {
        width: 120px;
        /* Width for the first column */
    }

    .text-pending {
        color: orange;
    }

    .text-rejected {
        color: red;
    }


    .estimate-date {
        color: green;
    }

    .text-danger {
        color: red;
    }

    .flex-container {
        display: flex;
        gap: 10px;
        /* Adjust the spacing between buttons */
        /* Align items in the center vertically */
        align-items: center;
    }

    .flex-item {
        /* Optionally, you can set a margin here */
        margin: 0;
    }

    .progress {
        height: 40px;
        /* Adjust this value as needed */
        background-color: #e9ecef;
        /* Light background color for the progress bar container */
        border-radius: 0.25rem;
        /* Rounded corners for the progress bar container */
        overflow: hidden;
        /* Hide any overflow from the progress bar */
    }

    /* Style for the progress bar */
    .progress-bar {
        height: 90%;
        /* Ensure the progress bar takes the full height of the container */
        line-height: 40px;
        /* Center the text vertically */
        font-size: 16px;
        /* Adjust text size as needed */
        color: #fff;
        /* Text color */
        background-color: #007bff;
        /* Adjust the color as needed */
        transition: width 0.6s ease;
        /* Smooth transition for width changes */
    }

    .flex-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
        margin-top: 50px;
        margin-bottom: 50px;
    }

    .flex-container2 {
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .stat-card {
        background-color: #f8f9fa;
        /* Light gray background */
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
        border-radius: 10px;
        /* Rounded corners */
        padding: 20px;
        text-align: center;
        width: 200px;
        /* Fixed width */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Add hover effect transition */
    }

    .stat-card h3 {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        /* Dark text */
        margin-bottom: 10px;
    }

    .stat-card p {
        font-size: 32px;
        font-weight: bold;
        color: #4CAF50;
        /* Green color for the numbers */
    }

    .stat-card:hover {
        transform: translateY(-10px);
        /* Hover effect: move card upwards */
        box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.15);
        /* Increase shadow on hover */
    }

    @media (max-width: 768px) {
        .flex-container {
            flex-direction: column;
            align-items: center;
        }

        .stat-card {
            width: 90%;
            /* Make the cards take full width on smaller screens */
        }
    }

    /* Style for the table */
    .nested-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        text-align: left;
        background-color: #f9f9f9;
    }

    /* Style for table headers */
    .nested-table thead th {
        background-color: #2C3E50;
        color: #fff;
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }

    /* Style for table rows */
    .nested-table tbody tr {
        border-bottom: 1px solid #ddd;
    }

    /* Style for table cells */
    .nested-table tbody td {
        padding: 12px;
        text-align: center;
        vertical-align: middle;
        border: 1px solid #ddd;
    }

    /* Progress bar styling */
    .progress {
        background-color: #f1f1f1;
        border-radius: 5px;
        overflow: hidden;
        height: 20px;
    }

    .progress-bar {
        background-color: #28a745;
        height: 100%;
        line-height: 20px;
        color: white;
        font-size: 14px;
        text-align: center;
    }

    /* Buttons and form styling */
    .btn-primary {
        background-color: #3498DB;
        border: none;
        padding: 6px 12px;
        font-size: 14px;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-danger {
        background-color: #E74C3C;
        border: none;
        padding: 6px 12px;
        font-size: 14px;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Date and status color styles */
    .text-success {
        color: #28a745;
    }

    .text-danger {
        color: #E74C3C;
    }

    .text-pending {
        color: #FFC107;
        font-weight: bold;
    }

    .text-rejected {
        color: #E74C3C;
        font-weight: bold;
    }

    /* Flexbox for buttons */
    .flex-container {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .flex-item {
        margin: 5px;
    }

    /* Form styles */
    .update-form input[type="text"],
    .update-form input[type="date"] {
        width: 100px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .update-form button {
        margin-left: 10px;
    }

    /* Hover effect for rows */
    .nested-table tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>@endsection