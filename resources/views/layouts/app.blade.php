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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .after {
            background-color: gray;
            color: white;
            margin-left: 20px;
            margin-top: 20px;
        }

        .before {
            background-color: #343a40 !important;
            color: white;
            margin-left: 20px;
            margin-top: 20px;
        }

        .custom-navbar {
            margin: 10px;
            border-radius: 10px;
            height: 100px;
            overflow: hidden;
            position: relative;
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
            /* Hindari efek transisi saat animasi manual */
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar"><img src="{{ asset('img/logo_pln.jpg') }}" alt="Logo PLN" height="50px" class="mr-2 ml-2" style="border-radius: 5px;"><a class="navbar-brand" href="#">P L N</a>
        <div class="slogan-wrapper">
            <div class="slogan-text" id="marqueeText">Listrik Untuk Kehidupan Yang Lebih Baik</div>
        </div><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="{{ request()->is('carinokontrol') ? 'after' :'before' }}" href="{{ route('carinokontrol') }}">Cari Data Pemakaian</a></li>
                <li class="nav-item"><a class="{{ request()->is('laporankeuangan') ? 'after' :'before' }}" href="{{ route('laporankeuangan') }}">Laporan Keuangan</a></li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="form-inline">@csrf <button class="btn btn-outline-light ml-2" type="submit">Logout</button></form>
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