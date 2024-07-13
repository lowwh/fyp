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
                                                                                                            $uniqueFreelancerIds[] = $result->freelancer_id
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
                                                                                                                            <th>Bidder Name</th>
                                                                                                                            <th>Progress Bar</th>
                                                                                                                            <th>Progress</th>
                                                                                                                            <th>Actions</th>
                                                                                                                        </tr>
                                                                                                                    </thead>
                                                                                                                    <tbody>
                                                                                                                        @foreach ($results as $innerResult)
                                                                                                                            @can('view', $innerResult)
                                                                                                                                @if ($innerResult->freelancer_id === $result->freelancer_id)
                                                                                                                                    <tr>
                                                                                                                                        <td>{{ $innerResult->gig_id }}</td>
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
                                                                                                                                                    <span class="text-rejected"==='Rejected'>Rejected</span>

                                                                                                                                                @endif
                                                                                                                                                @if($innerResult->progress == 100.00 && $innerResult->exists)
                                                                                                                                                    <span class="text-success">{{ $innerResult->status }}</span>
                                                                                                                                                @endif
                                                                                                                                            @endcan
                                                                                                                                            @can('isUser')
                                                                                                                                                @if($innerResult->status === 'Pending' || $innerResult->status === 'Rejected')
                                                                                                                                                    <span class="text-pending">Pending</span>
                                                                                                                                                @endif
                                                                                                                                                @if ($innerResult->progress == 100.00 && $innerResult->exists)
                                                                                                                                                    <span class="text-success">{{ $innerResult->status }}</span>
                                                                                                                                                @endif
                                                                                                                                            @endcan
                                                                                                                                        </td>
                                                                                                                                        <td>
                                                                                                                                            @can('isFreelancer')
                                                                                                                                                @if($innerResult->status === 'Pending' || $innerResult->status === 'Rejected')
                                                                                                                                                    <button class="btn btn-primary update-btn">Update</button>
                                                                                                                                                    <form class="delete-form"
                                                                                                                                                        action="{{ route('result.delete', $innerResult->id) }}"
                                                                                                                                                        method="GET" style="display: inline;">
                                                                                                                                                        @csrf
                                                                                                                                                        <button type="submit"
                                                                                                                                                            class="btn btn-danger delete-btn">Delete</button>
                                                                                                                                                    </form>
                                                                                                                                                @endif
                                                                                                                                            @endcan
                                                                                                                                            @can('isUser')
                                                                                                                                                @if($innerResult->progress === '100.00' && $innerResult->status === 'Pending')
                                                                                                                                                    <div class="flex-container">
                                                                                                                                                        <form
                                                                                                                                                            action="/showrating/{{ $innerResult->resultid }}/{{$innerResult->userid}}"
                                                                                                                                                            method="get">
                                                                                                                                                            <button type="submit"
                                                                                                                                                                class="btn btn-success btn-sm flex-item">Done</button>
                                                                                                                                                        </form>
                                                                                                                                                        <form
                                                                                                                                                            action="{{ route('reject-progress', ['resultid' => $innerResult->resultid, 'userid' => $innerResult->userid]) }}"
                                                                                                                                                            method="get">
                                                                                                                                                            <button type="submit"
                                                                                                                                                                class="btn btn-danger btn-sm flex-item">Reject</button>
                                                                                                                                                        </form>
                                                                                                                                                    </div>
                                                                                                                                                @endif
                                                                                                                                                @if($innerResult->progress === '100.00' && $innerResult->status === 'Rejected')
                                                                                                                                                    <div class="flex-container">
                                                                                                                                                        <form
                                                                                                                                                            action="/showrating/{{ $innerResult->resultid }}/{{$innerResult->userid}}"
                                                                                                                                                            method="get">
                                                                                                                                                            <button type="submit"
                                                                                                                                                                class="btn btn-success btn-sm flex-item">Done</button>
                                                                                                                                                        </form>
                                                                                                                                                        <form
                                                                                                                                                            action="{{ route('reject-progress', ['resultid' => $innerResult->resultid, 'userid' => $innerResult->userid]) }}"
                                                                                                                                                            method="get">
                                                                                                                                                            <button type="submit"
                                                                                                                                                                class="btn btn-danger btn-sm flex-item">Reject</button>
                                                                                                                                                        </form>
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
</script>

@endsection

<style>
    .flex-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .flex-item {
        margin-right: 0;
    }

    .text-pending {
        color: orange;
    }

    .text-rejected {
        color: red;
    }
</style>