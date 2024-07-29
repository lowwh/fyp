<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
    <title>INDEPENDENT CONTRACTOR COMMUNITY</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        :root {
            --primary-color: #ff0147;
            --secondary-color: #212429;
            --text-light: #d1d5db;
            --white: #ffffff;
            --max-width: 1200px;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
            transition: 0.3s;
        }

        ul {
            list-style: none;
        }

        body {
            font-family: "Poppins", sans-serif;
            background-image: url('{{ asset('images/bg.png') }}');
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
        }

        nav {
            position: fixed;
            isolation: isolate;
            width: 100%;
            max-width: var(--max-width);
            margin-inline: auto;
            z-index: 9;
        }

        .nav__header {
            padding: 1rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--primary-color);
        }

        .nav__logo a {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--white);
        }

        .nav__logo img {
            display: flex;
            max-width: 36px;
        }

        .nav__logo span {
            display: none;
        }

        .nav__menu__btn {
            font-size: 1.5rem;
            color: var(--white);
            cursor: pointer;
        }

        .nav__links {
            position: absolute;
            top: 65px;
            left: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 2rem;
            padding: 2rem;
            background-color: var(--primary-color);
            transition: 0.5s;
            z-index: -1;
            transform: translateY(-100%);
        }

        .nav__links.open {
            transform: translateY(0);
        }

        .nav__links a {
            font-size: 1.2rem;
            color: var(--white);
        }

        .nav__links a:hover {
            color: var(--secondary-color);
        }

        .header__container {
            max-width: var(--max-width);
            margin-inline: auto;
            padding-block: 5rem 2rem;
            padding-inline: 1rem;
            display: grid;
            gap: 2rem;
        }

        .header__image img {
            width: 100%;
            max-width: 500px;
            margin-inline: auto;
            display: flex;
        }

        .header__content {
            overflow: hidden;
            text-align: center;
        }

        .header__content h2 {
            position: relative;
            isolation: isolate;
            max-width: fit-content;
            margin-left: auto;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: 500;
            color: var(--primary-color);
            text-align: right;
        }

        .header__content h2::before {
            position: absolute;
            content: "";
            top: 50%;
            left: 0;
            transform: translate(calc(-100% - 1rem), -50%);
            height: 2px;
            width: 150%;
            background-color: var(--white);
        }

        .header__content h1 {
            font-size: 5rem;
            font-weight: 600;
            color: var(--white);
            line-height: 5rem;
        }

        .h1__span-1 {
            font-size: 4rem;
            color: var(--primary-color);
        }

        .h1__span-2 {
            font-size: 2rem;
            font-weight: 400;
        }

        .header__content p {
            margin-bottom: 2rem;
            color: var(--text-light);
        }

        .header__content .btn {
            padding: 0.75rem 1.5rem;
            outline: none;
            border: none;
            font-size: 1rem;
            color: var(--white);
            background-color: var(--primary-color);
            border-radius: 5rem;
            transition: 0.3s;
            cursor: pointer;
        }

        .header__content .btn:hover {
            color: var(--primary-color);
            background-color: var(--white);
        }

        .socials {
            padding-block: 2rem 4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .socials a {
            font-size: 1.5rem;
            color: var(--text-light);
        }

        .socials a:hover {
            color: var(--primary-color);
        }

        .header__bar {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        @media (width > 768px) {
            nav {
                position: static;
                padding: 2rem 1rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 2rem;
            }

            .nav__header {
                padding: 0;
                background-color: transparent;
            }

            .nav__logo span {
                display: flex;
            }

            .nav__menu__btn {
                display: none;
            }

            .nav__links {
                position: static;
                padding: 0;
                flex-direction: row;
                justify-content: flex-end;
                gap: 3rem;
                background-color: transparent;
                transform: none;
            }

            .nav__links a:hover {
                color: var(--primary-color);
            }

            .header__container {
                grid-template-columns: repeat(2, 1fr);
                align-items: center;
                padding-block: 2rem;
            }

            .header__image {
                grid-area: 1/2/2/3;
            }

            .header__content {
                text-align: left;
            }

            .socials {
                justify-content: flex-start;
            }
        }
    </style>
</head>

<body>
    <nav>
        <div class="nav__header">
            <div class="nav__logo">
                <a href="#">
                    <img src="{{url('/images/logo.png')}}" alt="Image" />
                    <span>PLATFORM FOR INDEPENDENT CONTRACTOR COMMUNITIES</span>
                </a>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <ul class="nav__links" id="nav-links">


            <li><a href="#">Features</a></li>
            <li><a href="#">News</a></li>
            <li class="nav-item"><a href="/register" class="nav-link active">Register</a></li>
            @if (Route::has('login'))
                @auth
                    <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link active">Home</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link active">Log in</a></li>
                @endauth
            @endif
        </ul>

    </nav>
    <header class="header__container">
        <div class="header__image">
            <img src="{{url('/images/header.png')}}" alt="Image" />
        </div>
        <div class="header__content">
            <h2>INDEPENDENT CONTRACTOR COMMUNITY</h2>
            <h1>
                Empower Your Freelance<br /><span class="h1__span-1">Career</span>
                <span class="h1__span-2">with Our Community</span>
            </h1>
            <p>
                From finding clients to securing projects, our dedicated platform is here to support your freelance
                journey. Join us to connect with opportunities and elevate your career to new heights.
            </p>
            <div class="header__btn">
                <button class="btn">Learn More</button>
            </div>
            <ul class="socials">
                <li>
                    <a href="#"><i class="ri-facebook-circle-fill"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ri-twitter-fill"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ri-youtube-fill"></i></a>
                </li>
            </ul>
            <div class="header__bar">
                PLATFORM FOR INDEPENDENT CONTRACTOR COMMUNITIES © 2024. All Rights Reserved.
            </div>
        </div>
    </header>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script>const menuBtn = document.getElementById("menu-btn");
        const navLinks = document.getElementById("nav-links");
        const menuBtnIcon = menuBtn.querySelector("i");

        menuBtn.addEventListener("click", (e) => {
            navLinks.classList.toggle("open");

            const isOpen = navLinks.classList.contains("open");
            menuBtnIcon.setAttribute(
                "class",
                isOpen ? "ri-close-line" : "ri-menu-line"
            );
        });

        navLinks.addEventListener("click", (e) => {
            navLinks.classList.remove("open");
            menuBtnIcon.setAttribute("class", "ri-menu-line");
        });

        const scrollRevealOption = {
            distance: "50px",
            origin: "bottom",
            duration: 1000,
        };

        ScrollReveal().reveal(".header__image img", {
            ...scrollRevealOption,
            origin: "right",
        });
        ScrollReveal().reveal(".header__content h2", {
            ...scrollRevealOption,
            delay: 500,
        });
        ScrollReveal().reveal(".header__content h1", {
            ...scrollRevealOption,
            delay: 1000,
        });
        ScrollReveal().reveal(".header__content p", {
            ...scrollRevealOption,
            delay: 1500,
        });
        ScrollReveal().reveal(".header__content .header__btn", {
            ...scrollRevealOption,
            delay: 2000,
        });
        ScrollReveal().reveal(".header__content .socials", {
            ...scrollRevealOption,
            delay: 2500,
        });
        ScrollReveal().reveal(".header__bar", {
            ...scrollRevealOption,
            delay: 3000,
        });
    </script>
</body>