<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Student Result Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a href="#" class="nav-link active">Check Result</a></li>
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
    <section>
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            Notice Details
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $notice->notice_title }}</h5>
                            <p class="card-text">{{ $notice->notice_content }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
