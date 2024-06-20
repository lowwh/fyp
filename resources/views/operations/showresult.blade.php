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

        .result-container {
            background-color: lightblue;
            padding: 10px;
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
            <button class="btn btn-primary me-5" onclick="history.back()">Back</button>
            <a class="navbar-brand" href="/">INDEPENDENT CONTRACTOR COMMUNITIES PLATFORM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
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
        <h2 class="text-center">Search for Freelancer Results</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" action="{{ route('search.result') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" id="servicetype" name="servicetype" class="form-control"
                            placeholder="Enter Service Type" aria-label="Enter Service Type"
                            aria-describedby="searchButton">
                        <button class="btn btn-primary" type="submit" id="searchButton">Search</button>
                    </div>
                </form>
                @if(isset($results) && !$results->isEmpty())
                    <div class="card">
                        <div class="card-header text-black" style="background-color: #E5E5E5;">
                            Freelancer Result
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Student Information -->
                                <div class="col-md-15 mb-5" style="background-color: #E5E5E5;">
                                    <p class="card-text"><strong>Service Type:</strong> {{ $results[0]->servicetype }}</p>
                                </div>
                            </div>
                            <!-- Result Details -->

                            @foreach($results as $result)
                                <div class="row mb-5">
                                    <div class="result-container" style="background-color: #E5E5E5;">
                                        <div class="col-md-8">
                                            <p><strong>Service Title:</strong> {{ $result->title }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Service Type:</strong> {{ $result->servicetype }}</p>
                                        </div>
                                        <div class="col-md-8">
                                            <p><strong>Service Description:</strong> {{ $result->description }}</p>
                                        </div>
                                        <a href="/viewservice/{{$result->userid}}/{{$result->serviceid}}"
                                            class="btn btn-secondary mt-auto" style="margin-left: 520px;">View</a>
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
                    <div class="alert alert-danger mt-3" role="alert" style="height: 500px;"> {{ $error }}
                        <div class="py-5 bg-image-full"
                            style="background-image: url('images/no_result.gif'); background-size: cover; height: 100vh;">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>



</body>

</html>