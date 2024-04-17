<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('css/app.css') }}" rel="stylesheet">

    <style>
        /* Custom CSS for styling */
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            margin-top: 20px;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        @media print {

            .container form,
            .container button,
            .text-center {
                display: none;
            }
        }
    </style>

</head>

<body>

    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Student Result Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item"><a href="searchresult" class="nav-link active">Check Result</a></li> -->
                    @if (Route::has('login'))
                    @auth
                    <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link active">Management</a></li>
                    @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link active">Log in</a></li>

                    <!-- @if (Route::has('register'))
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link active">Register</a></li>
                    @endif -->
                    @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <br />
    <!-- Content section-->

    <div class="container">
        <h2 class="text-center">Search for Student Results</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" action="{{ route('search.result') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" id="studentId" name="student_id" class="form-control" placeholder="Enter Student ID" aria-label="Enter Student ID" aria-describedby="searchButton">
                        <button class="btn btn-primary" type="submit" id="searchButton">Search</button>
                    </div>
                </form>
                @if(isset($results) && !$results->isEmpty())
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Student Result
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Student Information -->
                            <div class="col-md-12 mb-3">
                                <h5 class="card-title">Student Information</h5>
                                <p class="card-text"><strong>Name:</strong> {{ $results[0]->name }}</p>
                                <p class="card-text"><strong>Student ID:</strong> {{ $results[0]->student_id }}</p>
                            </div>
                        </div>
                        <!-- Result Details -->
                        @foreach($results as $result)
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <p><strong>Course:</strong> {{ $result->course }}</p>
                            </div>
                            <div class="col-md-8">
                                <p><strong>Result Score:</strong> {{ $result->result_score }}</p>
                            </div>
                        </div>
                        @endforeach
                        <!-- Print button -->
                        <div class="text-center">
                            <button class="btn btn-primary" onclick="window.print()">Print</button>
                        </div>
                    </div>
                </div>
                @elseif(isset($error))
                <div class="alert alert-danger mt-3" role="alert">
                    {{ $error }}
                </div>
                @endif
            </div>
        </div>
    </div>



</body>

</html>