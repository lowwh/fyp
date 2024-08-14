@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Navbar with user's name in the upper right -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm rounded">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Profile</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">{{ $user->name }}</span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link"><i class="fas fa-check-circle text-success"></i> 100% job complete</span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link"><i class="fas fa-clock text-success"></i> 100% on time</span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Central content with tabs -->
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10">
            <div class="card mb-4 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <!-- User Info -->
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            @if($user->image_path)
                                <img src="{{ asset('storage/' . $user->image_path) }}" alt="Profile Image"
                                    class="img-fluid rounded-circle border border-2 border-light"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/noimage.jfif') }}" alt="No Image"
                                    class="img-fluid rounded-circle border border-2 border-light"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h3 class="font-weight-bold mb-2">{{ $user->name }}</h3>
                            <p class="text-muted mb-4">{{ $user->servicetype }}</p>
                            <p class="text-muted mb-4">
                                <span class="badge bg-success">100% Job Complete</span>
                                <span class="badge bg-success">100% On Time</span>
                            </p>
                        </div>
                    </div>

                    <!-- Tabs for BIO, Project, Review, and My Wallet -->
                    <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="bio-tab" data-bs-toggle="tab" href="#bio" role="tab"
                                aria-controls="bio" aria-selected="true">BIO</a>
                        </li>
                        @can('isFreelancer')
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="project-tab" data-bs-toggle="tab" href="#project" role="tab"
                                    aria-controls="project" aria-selected="false">Project</a>
                            </li>
                        @endcan
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="review-tab" data-bs-toggle="tab" href="#review" role="tab"
                                aria-controls="review" aria-selected="false">Review</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="mywallet-tab" data-bs-toggle="tab" href="#mywallet" role="tab"
                                aria-controls="mywallet" aria-selected="false">My Wallet</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content" id="profileTabContent">
                        <!-- BIO Tab -->
                        <div class="tab-pane fade show active" id="bio" role="tabpanel" aria-labelledby="bio-tab">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Freelancer ID:</h5>
                                    <p>{{ $user->freelancer_id }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Freelancer Name:</h5>
                                    <p>{{ $user->name }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Gender:</h5>
                                    <p>{{ $user->gender }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Age:</h5>
                                    <p>{{ $user->age }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Email:</h5>
                                    <p>{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Service Type:</h5>
                                    <p>{{ $user->servicetype }}</p>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-primary btn-lg px-5" data-bs-toggle="modal"
                                    data-bs-target="#updatedetailModal{{ $user->id }}">
                                    Edit
                                </button>
                            </div>
                        </div>

                        @can('isFreelancer')
                            <!-- Project Tab -->
                            <div class="tab-pane fade" id="project" role="tabpanel" aria-labelledby="project-tab">
                                <p>Project content goes here.</p>
                            </div>
                        @endcan

                        <!-- Review Tab -->
                        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                            <p>Review content goes here.</p>
                        </div>

                        <!-- My Wallet Tab -->
                        <div class="tab-pane fade" id="mywallet" role="tabpanel" aria-labelledby="mywallet-tab">
                            <div class="row mb-4">
                                <!-- Current Balance -->
                                <div class="col-md-12 mb-4">
                                    <h4 class="font-weight-bold">Current Balance:</h4>
                                    <h3 class="text-success">RM{{$user->balance}}</h3>
                                    <button type="button" class="btn btn-primary btn-lg px-5" data-bs-toggle="modal"
                                        data-bs-target="#updatebalanceModal{{ $user->id }}">
                                        Top Up
                                    </button>

                                </div>


                            </div>

                            <!-- Total Spending -->
                            <div class="row mb-4">
                                <div class="col-md-12 mb-4">
                                    @can('isUser')
                                        <h4 class="font-weight-bold">Total Spending:</h4>
                                        <h3 class="text-success ">RM{{$totalSpend}}</h3>
                                    @endcan
                                    @can('isFreelancer')
                                        <h4 class="font-weight-bold">Total Earn:</h4>
                                        <h3 class="text-success">RM{{$totalEarn}}</h3>
                                    @endcan
                                </div>
                            </div>

                            <!-- Past Transactions -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="font-weight-bold">Past Transactions:</h4>
                                    @if ($pastTransactions->isEmpty())
                                        <p>No past transactions found.</p>
                                    @else
                                        <div class="list-group">
                                            @foreach ($pastTransactions as $invoice)
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h5 class="mb-1">Invoice Number: {{ $invoice->invoice_number }}</h5>
                                                        <small>Status: {{ ucfirst($invoice->status) }}</small>
                                                    </div>
                                                    <p class="mb-1">
                                                        Amount: ${{ number_format($invoice->amount, 2) }}<br>
                                                        Payment Method: {{ ucfirst($invoice->payment_method) }}<br>
                                                        Service ID: {{ $invoice->service_id }}
                                                    </p>
                                                    <small>
                                                        Created At:
                                                        @if ($invoice->created_at)
                                                            {{ $invoice->created_at->format('Y-m-d H:i') }}
                                                        @else
                                                            Not Available
                                                        @endif
                                                    </small>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update balance modal -->
    <div class="modal fade" id="updatebalanceModal{{$user->id}}" tabindex="-1" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title" id="updateModalLabel">Update Balance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/update/balance/{{$user->id}}">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount:</label>
                            <input type="text" class="form-control" id="amount" name="amount">
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Update Detail Modal -->
    <div class="modal fade" id="updatedetailModal{{ $user->id }}" tabindex="-1" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title" id="updateModalLabel">Update Profile Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" enctype="multipart/form-data" action="/uploadphoto/{{$user['id']}}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image: </label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="servicetype" class="form-label">Service Type:</label>
                            <input type="text" class="form-control" id="servicetype" name="servicetype"
                                value="{{ $user->servicetype }}">
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* My Wallet Tab */
    #mywallet .list-group-item {
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
        margin-bottom: 1rem;
    }

    #mywallet .list-group-item:hover {
        background-color: #f8f9fa;
    }

    #mywallet .text-success {
        font-size: 1.5rem;
    }

    #mywallet .text-danger {
        font-size: 1.5rem;
    }
</style>
@endsection