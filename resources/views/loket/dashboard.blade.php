<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Loket</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- (Optional) Bootstrap 5 JS dan Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <a href="{{ route('carinokontrol') }}">Cari Data Pemakaian</a>

    {{-- <a href="{{ route('laporan') }}">Laporan Keuangan </a> --}}
    <br>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">Total Biaya Beban</div>
                    <div class="card-body">
                        <h3 class="card-title text-primary">
                            Rp {{ number_format($totalBiayaBeban, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">Total Biaya Pemakaian</div>
                    <div class="card-body">
                        <h3 class="card-title text-success">
                            Rp {{ number_format($totalBiayaPemakai, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">Total Keseluruhan</div>
                    <div class="card-body">
                        <h3 class="card-title text-success">
                            Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</html>
