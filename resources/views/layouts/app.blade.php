<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PLN</title>
    <link rel="icon" type="image/jpg" href="{{ asset('img/logo_pln.jpg') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <img src="{{ asset('img/logo_pln.jpg') }}" alt="Logo PLN" height="40px" class="mr-2 ml-2">
        <a class="navbar-brand" href="#">PLN</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-white" href="{{ route('carinokontrol') }}">Cari Data Pemakaian</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-white" href="{{ route('laporankeuangan') }}">Laporan Keuangan</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="form-inline">
                        @csrf
                        <button class="btn btn-outline-light ml-2" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Content --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
