<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keen Rabbits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-zFQqD/MO85+zHnJABmcHMQLFNCxOizM0Sk6ApxH93bwJgRANuW/4G9k4RYFQw3Dr" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* General styles */
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #555555;
            font-size: 15px;
        }

        .site-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            position: relative;
            z-index: 10;
        }

        .logo img {
            margin-left: 60%; /* Align logo dynamically for large screens */
            height: 40px;
            transition: all 0.3s ease; /* Smooth resizing */
        }

        .main-nav {
            display: flex;
        }

        .main-nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .main-nav ul li {
            margin: 0 10px;
        }

        .main-nav ul li a {
            text-decoration: none;
            color: #555555;
            font-weight: bold;
            padding: 8px 10px;
            text-transform: capitalize;
            transition: color 0.3s;
        }

        .main-nav ul li a:hover {
            color: #007BFF;
        }

        .menu-toggle-btn {
            display: none;
            font-size: 24px;
            background: none;
            border: none;
            cursor: pointer;
        }

        .auth-button {
            font-size: 15px;
            font-family: 'Open Sans', sans-serif;
            color: #000000;
            background-color: transparent;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .auth-button:hover {
            color: #0056b3;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .logo img {
                margin-left: 40%; /* Adjust logo position for medium screens */
                height: 35px;
            }
        }

        @media (max-width: 768px) {
            .main-nav {
                position: absolute;
                top: 70px;
                right: 0;
                background: #fff;
                flex-direction: column;
                width: 100%;
                display: none;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 20;
            }

            .main-nav ul {
                flex-direction: column;
                padding: 0;
            }

            .main-nav ul li {
                margin: 5px 0;
                text-align: center;
            }

            .menu-toggle-btn {
                display: block;
                color: #555555;
                margin-right: 10px;
            }

            .main-nav.active {
                display: flex;
            }

            .logo img {
                margin-left: 20%; /* Adjust for mobile screens */
                height: 30px;
            }

            .site-header {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 480px) {
            .logo img {
                margin-left: 10%; /* Adjust for very small screens */
                height: 25px;
            }
        }
    </style>
</head>
<body>
<header class="site-header">
    <div class="logo">
        <img src="/asset/frontend/images/includes/kr.png" alt="Keen Rabbits Logo">
    </div>
    <button class="btn btn-outline-secondary menu-toggle-btn" id="menuToggle">
        ☰
    </button>
    <nav class="main-nav" id="mainNav">
        <ul>
            <li><a href="https://keenrabbits.biz/">Home</a></li>
            <li><a href="https://keenrabbits.biz/services">Services</a></li>
            <li><a href="https://keenrabbits.biz/portfolio">Portfolio</a></li>
            <li><a href="https://keenrabbits.biz/about">About Us</a></li>
            <li><a href="https://keenrabbits.biz/contact">Contact Us</a></li>
            <li><a href="#">Blog</a></li>
            <li>
                @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-1 justify-end">
                        @auth
                            <a href="{{ Auth::user()->type == 1 ? route('admin.dashboard') : route('user.dashboard', Auth::user()->id) }}" class="auth-button">

                            <i class="bi bi-person-fill"></i>
                            </a>

                        @else
                            <div class="auth-links" style="display: inline-flex; gap: 10px; align-items: center;">
                                <a
                                    href="{{ route('login') }}"
                                    class="auth-button login-button"
                                >
                                    <i class="bi bi-person-fill"></i>
                                </a>
                            </div>
                        @endauth
                    </nav>
                @endif
            </li>
        </ul>
    </nav>
</header>

<script>
    // Toggle menu visibility on smaller screens
    const menuToggle = document.getElementById('menuToggle');
    const mainNav = document.getElementById('mainNav');

    menuToggle.addEventListener('click', () => {
        mainNav.classList.toggle('active');
    });
</script>
</body>
</html>
