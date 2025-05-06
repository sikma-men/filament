<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLN - Listrik untuk Kehidupan Lebih Baik</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f9fa;
        }

        .hero-section {
            padding: 60px 0;
        }

        .pln-logo {
            height: 40px;
            border-radius: 5px;
            margin-right: 10px;
        }

        .brand-text {
            font-weight: 700;
            color: #00aeef;
            font-size: 20px;
        }

        .headline {
            font-weight: 700;
            font-size: 22px;
            color: #1d1d1d;
        }

        .description {
            font-size: 14px;
            color: #333;
            margin: 20px 0;
            line-height: 1.7;
        }

        .btn-primary {
            background-color: #00aeef;
            border: none;
            padding: 10px 20px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #0098d4;
        }

        .worker-img {
            max-width: 100%;
            height: auto;
        }

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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar">
        <img src="{{ asset('img/logo_pln.jpg') }}" alt="Logo PLN" height="50px" class="mr-2 ml-2" style="border-radius: 5px;">

        <a class="navbar-brand" href="#">P L N</a>

        <div class="slogan-wrapper">
            <div class="slogan-text" id="marqueeText">Listrik Untuk Kehidupan Yang Lebih Baik</div>
        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <body>
        <div class="container hero-section" style="margin-top: -50px;">
        <!-- align-items-center -->
            <div class="row  justify-content-center">
                <!-- Kiri: Logo + Teks -->
                <div class="col-md-6 " style="margin-top: 120px;">
                    <div class="headline">PLN – Listrik Untuk Kehidupan Yang Lebih Baik.</div>
                    <div class="description">
                        Menerangi Dunia, Mendorong Kemajuan. <br>
                        Dari Indonesia, kami hadirkan energi yang menghubungkan setiap orang, membuka jalan untuk kemudahan,
                        keberlanjutan, dan inovasi bagi masa depan yang lebih baik.
                    </div>
                    <a href="{{'pemakaian'}}" class="btn btn-primary">Cek Data Pemakaian</a>
                </div>

                <!-- Kanan: Gambar pekerja -->
                <div class="col-md-6 text-center">
                    <img src="img/orang[1].png" alt="Petugas PLN" class="worker-img" style="width:450px; height:auto;">
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const marquee = document.getElementById('marqueeText');
                let lastTime = performance.now();
                let lastPos = parseFloat(localStorage.getItem('marqueePosition')) || 0;

                function animateMarquee(time) {
                    const delta = (time - lastTime) / 1000;
                    lastTime = time;

                    const speed = 35; // pixel per second
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
    </body>

</html>
