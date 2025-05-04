<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLN</title>
    <link rel="icon" type="image/jpg" href="{{ asset('img/logo_pln.jpg') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .custom-navbar {
            margin: 10px;
            border-radius: 10px;
            height: 100px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 30px 4px 30px rgba(0, 0, 0, 0.1);
            background-color: #343a40;
            /* supaya tetap gelap ketika fixed */
        }



        .navbar-brand {
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
            overflow: hidden;
            white-space: nowrap;
            z-index: 1;
        }

        .slogan-text {
            display: inline-block;
            color: white;
            font-size: 20px;
            white-space: nowrap;
        }

        .logout-icon {
            color: white;
            font-size: 24px;
            margin-right: 5px;
        }

        /* Link dasar */
        .before,
        .after {
            color: white;
            background-color: transparent;
            border-radius: 10px;
            padding: 10px 20px;
            display: inline-block;
            text-decoration: none;
            position: relative;
            margin-right: 30px;
        }

        /* Aktif - garis bawah putih */
        /* Aktif - garis bawah putih */
        .after::after {
            content: '';
            position: absolute;
            bottom: 0px;
            left: 50%;
            transform: translateX(-50%);
            width: 40%;
            height: 2px;
            background-color: white;
            border-radius: 2px;
        }

        /* Hover untuk non-aktif link */
        .before::after {
            content: '';
            position: absolute;
            bottom: 0px;
            left: 50%;
            transform: translateX(-50%);
            width: 0%;
            height: 2px;
            background-color: white;
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .before:hover::after {
            width: 40%;
        }


        /* Hover efek tambahan */
        .ahover:hover {
            text-decoration: none;
            color: white;
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }

        .nav-item.dropdown .dropdown-menu {
            position: absolute;
            z-index: 9999;
            top: 100%;
            left: -80px;
        }

        .dropdown-menu .dropdown-item.active {
            background-color: #00aeef;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body style="padding-top: 120px;">

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const marquee = document.getElementById('marqueeText');
            let lastTime = performance.now();
            let lastPos = parseFloat(localStorage.getItem('marqueePosition')) || 0;

            function animateMarquee(time) {
                const delta = (time - lastTime) / 1000;
                lastTime = time;
                const speed = 35;
                lastPos -= delta * speed;

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
        <img src="{{ asset('img/logo_pln.jpg') }}" alt="Logo PLN" height="50px" class="mr-2 ml-2"
            style="border-radius: 5px;">
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
                    <a class="{{ request()->is('loket/pemakaian') ? 'after' : 'before' }} ahover"
                        href="{{ route('loket.pemakaian') }}">
                        Cari Data Pemakaian
                    </a>
                </li>

                <!-- Laporan Keuangan Dropdown -->
                <a class="{{ request()->is('loket/laporankeuangan/*') ? 'after' : 'before' }} ahover"
                    href="{{ route('loket.laporankeseluruhan') }}">
                    Laporan Keuangan
                </a>

                <!-- User Dropdown -->
                <li class="nav-item costum-li">
                    <form id="logout-form" action="{{ route('loket.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-link before ahover"
                            style="color: white; font-size: 18px;">
                            <i class="fas fa-sign-out-alt logout-icon"></i> Logout
                        </button>
                    </form>
                </li>

            </ul>
        </div>
    </nav>


    <div class="container mt-4">@yield('content')</div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
