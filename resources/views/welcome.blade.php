<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Platform for Independent Contractor Communities" />
    <meta name="author" content="P2_02" />
    <title>PLATFORM FOR INDEPENDENT CONTRACTOR COMMUNITIES</title>

    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Additional custom styles -->
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
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

        .scrollable-notice {
            max-height: 170px;
            overflow-y: auto;
        }

        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        .flip-card {
            height: 300px;
            perspective: 1000px;
            transition: transform 0.6s;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 20px;
        }

        .flip-card-front {
            z-index: 2;
            transform: rotateY(0deg);
        }

        .flip-card-back {
            transform: rotateY(180deg);
        }

        .flip-card.flipped .flip-card-inner {
            transform: rotateY(180deg);
        }

        .card {
            border-radius: 20px;
            background-color: #f8f9fa;
        }

        .flip-card-inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        .cta-section {
            background: white;
            color: #000;
            padding: 50px 0;
        }

        .cta-section h2,
        .cta-section p {
            margin-bottom: 20px;
        }

        .cta-section a {
            text-transform: uppercase;
        }

        blockquote {
            background: #f9f9f9;
            border-left: 10px solid #ccc;
            margin: 1.5em 10px;
            padding: 0.5em 10px;
            quotes: "\201C" "\201D" "\2018" "\2019";
        }

        blockquote:before {
            color: #ccc;
            content: open-quote;
            font-size: 4em;
            line-height: 0.1em;
            margin-right: 0.25em;
            vertical-align: -0.4em;
        }

        blockquote p {
            display: inline;
        }

        .scrollable-notice {
            max-height: 170px;
            overflow-y: auto;
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 15px;
        }

        .scrollable-notice ul {
            list-style: none;
            padding: 0;
        }

        .scrollable-notice li {
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
            transition: background-color 0.3s;
        }

        .scrollable-notice li:hover {
            background-color: #e9ecef;
        }

        .scrollable-notice li a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1em;
            display: flex;
            align-items: center;
        }

        .scrollable-notice li a:hover {
            text-decoration: underline;
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
                <div class="col-xl-12 mt-5">
                    <h2>Notice Board</h2>
                    <hr />
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
                    <div class="col-lg-6 text-center">
                        <h2>Welcome to Our Platform</h2>
                        <p>Our platform is designed to empower electricians and painters to enter the gig economy with
                            confidence. Whether they specialize in residential lines, commercial work, interior design,
                            or exterior cladding, professionals in these industries will find great value in using this
                            platform.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center">Our Services</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="card-title">Painting</h3>
                                <div class="card flip-card">
                                    <div class="flip-card-inner">
                                        <div class="flip-card-front">
                                            <img src="images/background-image3.jfif" alt="Painting Service Front"
                                                class="card-img">
                                        </div>
                                        <div class="flip-card-back">
                                            <img src="images/background-image3.jfif" alt="Painting Service Back"
                                                class="card-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="card-title">Electrician</h3>
                                <div class="card flip-card">
                                    <div class="flip-card-inner">
                                        <div class="flip-card-front">
                                            <img src="images/background-image4.jfif" alt="Electrician Service Front"
                                                class="card-img">
                                        </div>
                                        <div class="flip-card-back">
                                            <img src="images/background-image4.jfif" alt="Electrician Service Back"
                                                class="card-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="card-title">Service 3</h3>
                                <div class="card flip-card">
                                    <div class="flip-card-inner">
                                        <div class="flip-card-front">
                                            <img src="images/background-image2.jpg" alt="Service 3 Front"
                                                class="card-img">
                                        </div>
                                        <div class="flip-card-back">
                                            <img src="images/background-image2.jpg" alt="Service 3 Back"
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
        <section class="cta-section text-center">
            <div class="container">
                <h2>Ready to Join?</h2>
                <p>Sign up today and start finding opportunities.</p>
                <a href="/register" class="btn btn-primary">Register</a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="main-footer">

            <div class="container">
                <p class="m-0 text-center text-white">
                    Copyright &copy; PLATFORM FOR INDEPENDENT CONTRACTOR COMMUNITIES {{ date('Y') }}
                </p>
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
            var flipCards = document.querySelectorAll('.flip-card');
            var flipInterval = 2000;

            function flip(card) {
                card.classList.toggle('flipped');
            }

            flipCards.forEach(function (card) {
                setInterval(function () {
                    flip(card);
                }, flipInterval);
            });
        });
    </script>
</body>

</html>