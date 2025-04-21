<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PLN</title>
    <link rel="icon" type="image/jpg" href="{{ asset('img/logo_pln.jpg') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Font Awesome (untuk ikon) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .ahover {
            text-decoration: none;
            color: white;
            background-color: transparent;
            transition: 0.3s;
            border-radius: 20px;
            padding: 10px 20px;
            display: inline-block;
            z-index: 2;
            margin-right: 10px;
            margin-left: 20px;
        }

        /* Efek ketika hover pada .ahover */
        .ahover:hover {
            text-decoration: none;
            background-color: gray !important;
            color: white;
            z-index: 3;
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }

        .after {
            text-decoration: none;
            color: white;
            background-color: gray !important;
            transition: 0.3s;
            border-radius: 20px;
            padding: 10px 20px;
            display: inline-block;
            z-index: 2;
        }

        .before {
            text-decoration: none;
            color: white;
            background-color: gray !important;
            transition: 0.3s;
            border-radius: 20px;
            padding: 10px 20px;
            display: inline-block;
            z-index: 2;
        }

        .before {
            background-color: #343a40 !important;
            color: white;
        }

        .custom-navbar {
            margin: 10px;
            border-radius: 10px;
            height: 100px;
            overflow: visible;
            /* Pastikan overflow diatur ke visible */
            position: relative;
            /* Pastikan navbar punya positioning untuk dropdown */
            z-index: 1;
            /* Pastikan navbar berada di bawah dropdown */
        }

        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 1000;
            font-size: 40px;
            color: #00aeef !important;
            position: relative;
            z-index: 2;
        }

        .slogan-wrapper {
            position: absolute;
            top: 57%;
            left: 175px;
            transform: translateY(-50%);
            width: 500px;
            height: auto;
            overflow: hidden;
            white-space: nowrap;
            z-index: 1;
        }

        .slogan-text {
            display: inline-block;
            color: white;
            font-size: 20px;
            white-space: nowrap;
            transition: none;
        }

        .logout-icon {
            color: white;
            font-size: 24px;
            margin-right: 5px;
        }

        .nav-item.dropdown .dropdown-menu {
            position: absolute;
            z-index: 9999;
            /* Dropdown berada di atas navbar */
            top: 100%;
            /* Dropdown muncul di bawah navbar */
            left: -80px;
        }
    </style>
</head>

<body>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const marquee = document.getElementById('marqueeText');
            let lastTime = performance.now();
            let lastPos = parseFloat(localStorage.getItem('marqueePosition')) || 0;

            function animateMarquee(time) {
                const delta = (time - lastTime) / 1000;
                lastTime = time;

                const speed = 100; // pixel per second
                lastPos -= delta * speed;

                // Reset posisi jika sudah lewat batas lebar teks
                const resetAt = -marquee.offsetWidth;

                if (lastPos < resetAt) {
                    lastPos = marquee.parentElement.offsetWidth;
                }

                marquee.style.transform = `translateX(${lastPos}px)`;
                localStorage.setItem('marqueePosition', lastPos);
                requestAnimationFrame(animateMarquee);
            }

            requestAnimationFrame(animateMarquee);
        });
    </script>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar">
        <img src="{{ asset('img/logo_pln.jpg') }}" alt="Logo PLN" height="50px" class="mr-2 ml-2" style="border-radius: 5px;">
        <a class="navbar-brand" href="#">P L N</a>
        <div class="slogan-wrapper">
            <div class="slogan-text" id="marqueeText">Listrik Untuk Kehidupan Yang Lebih Baik</div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item costum-li">
                    <a class="{{ request()->is('carinokontrol') ? 'after' :'before' }} ahover" href="{{ route('carinokontrol') }}">Cari Data Pemakaian</a>
                </li>
                <li class="nav-item costum-li">
                    <a class="{{ request()->is('laporankeuangan') ? 'after' :'before' }} ahover" href="{{ route('laporankeuangan') }}">Laporan Keuangan</a>
                </li>
                <li class="nav-item dropdown costum-li">
                    <!-- Dropdown untuk ikon profil -->
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle logout-icon"></i>
                    </a>
                    <div class="dropdown-menu" style="" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">@yield('content') </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>