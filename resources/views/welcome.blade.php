<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description"
        content="Student Result Management System - UECS3294 Advanced Web Application Development" />
    <meta name="author" content="P2_02" />
    <title>PLATFORM FOR INDEPENDENT CONTRACTOR COMMUNITIES</title>

    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

    <style>
        .scrollable-notice {
            max-height: 170px;
            overflow-y: auto;
        }

        .bg-image-full {
            background-position: center;
            background-size: cover;
            height: 500px;
            width: 100%;
            animation: slideShow 20s infinite;
            border-radius: 20px;
        }

        @keyframes slideShow {
            0% {
                background-image: url('images/background-image2.jpg');
            }

            33% {
                background-image: url('images/background-image4.jfif');
            }

            66% {
                background-image: url('images/freelancer-image.jpg');
            }

            100% {
                background-image: url('images/background-image3.jfif');
            }
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
        }

        .main-footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }

        .main-footer .container p {
            margin-bottom: auto;
            text-align: center;
        }

        .navbar-nav.ms-auto {
            margin-left: auto;
        }

        /* Ensure the images fit well within the card */
        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        /* Style for the flip cards */
        .flip-card {
            height: 300px;
            /* Adjust height to fit the image */
            perspective: 1000px;
            transition: transform 0.6s;

        }

        /* Inner flip card container */
        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }

        /* Front and back of the flip card */
        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 90%;
            height: 90%;
            backface-visibility: hidden;
            border-radius: 20px;

        }

        /* Front side of the flip card */
        .flip-card-front {
            z-index: 2;
            transform: rotateY(0deg);
        }

        /* Back side of the flip card */
        .flip-card-back {
            transform: rotateY(180deg);
        }

        /* Flipped state of the flip card */
        .flip-card.flipped .flip-card-inner {
            transform: rotateY(180deg);
        }

        .card {
            border-radius: 20px;
            background-color: darkolivegreen;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/">PLATFORM FOR INDEPENDENT CONTRACTOR COMMUNITIES</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a href="/register" class="nav-link active">Register</a></li>
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link active">Home</a></li>
                            @else
                                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link active">Log in</a></li>
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Image and Notice Board Section -->
        <div class="container my-5">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bg-image-full"></div>
                </div>
                <div class="col-xl-12" style="margin-top:30px">
                    <!-- order-0 places this column first on smaller screens, order-xl-1 places it second on xl screens -->
                    <h2>Notice Board</h2>
                    <hr color="#000" />
                    <div class="scrollable-notice">
                        <ul>
                            @foreach($notices as $notice)
                                <li><a
                                        href="{{ route('show.one.notice', ['id' => $notice->id]) }}">{{ $notice->notice_title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content section-->
        <section class="content py-5">
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h2>Welcome to Our Platform</h2>
                        <p>Our platform is designed to empower electricians and painter to enter the gig economy with
                            confidence. Whether they
                            specialize in residential lines, commercial work, interior design, or exterior cladding,
                            professionals in these
                            industries will find great value in using this platform.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="py-5">
            <div class="container">
                <h2 class="text-center">Our Services</h2>
                <div class="row">
                    <div class="col-md-4">
                        <!-- Service 1 Card -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Painting</h3>
                                <!-- Flip Card -->
                                <div class="card flip-card">
                                    <div class="card-body flip-card-inner">
                                        <!-- Front Side -->
                                        <div class="flip-card-front">
                                            <img src="images/background-image3.jfif" alt="Service 1 Front"
                                                class="card-img">
                                        </div>
                                        <!-- Back Side -->
                                        <div class="flip-card-back">
                                            <img src="images/background-image3.jfif" alt="Service 1 Back"
                                                class="card-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Service 2 Card -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Electrician</h3>
                                <!-- Flip Card -->
                                <div class="card flip-card">
                                    <div class="card-body flip-card-inner">
                                        <!-- Front Side -->
                                        <div class="flip-card-front">
                                            <img src="images/background-image4.jfif" alt="Service 2 Front"
                                                class="card-img">
                                        </div>
                                        <!-- Back Side -->
                                        <div class="flip-card-back">
                                            <img src="images/background-image4.jfif" alt="Service 2 Back"
                                                class="card-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Service 3 Card -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Service 2</h3>
                                <!-- Flip Card -->
                                <div class="card flip-card">
                                    <div class="card-body flip-card-inner">
                                        <!-- Front Side -->
                                        <div class="flip-card-front">
                                            <img src="images/background-image2.jpg" alt="Service 2 Front"
                                                class="card-img">
                                        </div>
                                        <!-- Back Side -->
                                        <div class="flip-card-back">
                                            <img src="images/background-image2.jpg" alt="Service 2 Back"
                                                class="card-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Testimonials Section -->
        <section class="bg-light py-5">
            <div class="container">
                <h2 class="text-center">What Our Users Say</h2>
                <div class="row">
                    <div class="col-md-4">
                        <blockquote>
                            <p>"This platform is amazing!"</p>
                            <footer>- User 1</footer>
                        </blockquote>
                    </div>
                    <div class="col-md-4">
                        <blockquote>
                            <p>"Helped me find great opportunities."</p>
                            <footer>- User 2</footer>
                        </blockquote>
                    </div>
                    <div class="col-md-4">
                        <blockquote>
                            <p>"Highly recommend it to contractors."</p>
                            <footer>- User 3</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="py-5">
            <div class="container text-center">
                <h2>Ready to Join?</h2>
                <p>Sign up today and start finding opportunities.</p>
                <a href="register" class="btn btn-primary">Register</a>

            </div>
        </section>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="py-5 bg-dark">
                <div class="container">
                    <p class="m-0 text-center text-white">
                        Copyright &copy; PLATFORM FOR INDEPENDENT CONTRACTOR COMMUNITIES {{ date('Y') }}
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <!-- Flip Card JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Select the inner cards
            var flipCards = document.querySelectorAll('.flip-card');

            // Set the time interval (in milliseconds) for flipping the cards
            var flipInterval = 2000; // 2 seconds

            // Function to add the 'flipped' class
            function flip(card) {
                card.classList.toggle('flipped');
            }

            // Set an interval to flip the cards continuously
            flipCards.forEach(function (card) {
                setInterval(function () {
                    flip(card);
                }, flipInterval);
            });
        });
    </script>
</body>

</html>