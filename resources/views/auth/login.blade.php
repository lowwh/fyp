<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css">

    <style>
        /* Custom CSS */
        body {
            background-image: url('/images/login-bg.jpg');
            background-size: cover;
            background-position: center;
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #fff;
        }

        .card-header {
            background-color: #343a40;
            color: #fff;
            border-bottom: 1px solid #343a40;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, border-color 0.3s;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-check-label {
            cursor: pointer;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 1rem 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .input-group-text {
            background-color: #fff;
            border: 1px solid #ced4da;
            cursor: pointer;
        }

        .social-login-btn {
            width: 100%;
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #6c757d;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .logo-img {
            filter: brightness(0.85) contrast(1.2);
            /* Adjust brightness and contrast */
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
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link active">Home</a></li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link active">Dashboard</a></li>
                        @else
                            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link active">Log in</a></li>
                            @if (Route::has('register'))
                                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link active">Register</a></li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <br />
    <!-- Content section-->
    <section class="py-5">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Platform Logo" width="150" class="logo-img">

                    </div>
                    <h2 class="text-center mb-4">Welcome Back!</h2>
                    <p class="text-center">Please enter your login details below.</p>

                    <div class="card">
                        <div class="card-header">{{ __('Login') }}</div>
                        <div class="card-body">



                            <!-- Login Form -->
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">
                                            <span class="input-group-text" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rememberMe">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
                                        </button>
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>



                    <!-- Footer Links -->
                    <div class="footer-links text-center">
                        <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    @include('layouts.footer1')

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        // Custom JavaScript
        document.addEventListener('DOMContentLoaded', function () {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('#navbarSupportedContent');
            const togglePassword = document.querySelector('#togglePassword');
            const passwordInput = document.querySelector('#password');

            navbarToggler.addEventListener('click', function () {
                navbarCollapse.classList.toggle('show');
            });

            // Toggle password visibility
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>

</html>