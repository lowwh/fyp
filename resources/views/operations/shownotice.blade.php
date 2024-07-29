<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            margin-bottom: 40px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            padding: 20px;
            border-bottom: 1px solid #0056b3;
        }

        .card-body {
            padding: 30px;
        }

        .card-title {
            font-size: 2em;
            margin-bottom: 20px;
            color: #343a40;
        }

        .card-text {
            font-size: 1.2em;
            line-height: 1.6;
            color: #495057;
        }

        .container {
            max-width: 800px;
        }

        .notice-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
            position: relative;
            overflow: hidden;
        }

        .notice-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(90deg, #007bff, #0056b3);
        }

        .back-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        .icon {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .notice-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">PLATFORM FOR INDEPENDENT CONTRACTOR COMMUNITIES</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link active">Management</a></li>
                        @else
                            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link active">Log in</a></li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content section-->
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="notice-container">
                        <div class="notice-header">

                            <h5 class="card-title">{{ $notice->notice_title }}</h5>
                        </div>
                        <p class="card-text">{{ $notice->notice_content }}</p>
                        <a href="{{ url()->previous() }}" class="back-btn">Back to Notices</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>