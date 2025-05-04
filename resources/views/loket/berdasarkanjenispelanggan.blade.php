@extends('layouts.app')
@section('content')

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .sidebar {
        width: 200px;
        height: 30vh;
        padding-top: 20px;
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: fixed;
        margin-left:-110px;
        margin-top:-15px;
    }

    .sidebar .nav-link {
        width: 160px;
        text-align: center;
        padding: 12px 10px;
        margin: 10px 0;
        font-weight: 600;
        color: #fff !important;
        border-radius: 15px;
        transition: all 0.3s ease-in-out;
        background-color: transparent;
    }

    .sidebar .nav-link:hover {
        background-color: #5e5e5e;
        color: #fff !important;
        transform: scale(1.03);
    }

    .sidebar .nav-link.active {
        background-color: #5e5e5e;
        color: #fff !important;
    }

    .content {
        margin-left: 220px;
        padding: 20px;
    }

    .costum-nav-item {
        margin-left: 20px;
    }

    .card h3 {
        font-size: 1.8rem;
    }
</style>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar navbar-dark bg-dark">
        <ul class="navbar-nav w-100">
            <li class="nav-item text-center costum-nav-item">
                <a class="nav-link {{ request()->routeIs('loket.laporankeseluruhan') ? 'active' : '' }}" href="{{ route('loket.laporankeseluruhan') }}">
                    Keseluruhan
                </a>
            </li>
            <li class="nav-item text-center costum-nav-item">
                <a class="nav-link {{ request()->routeIs('loket.laporanjenis') ? 'active' : '' }}" href="{{ route('loket.laporanjenis') }}">
                    Berdasarkan<br>Jenis Pelanggan
                </a>
            </li>
        </ul>
    </div> <!-- Tutup sidebar -->

    <!-- Main Content -->
    <div class="content flex-grow-1">
        <div class="container mt-5">
            <h2 class="text-center mb-5">Pendapatan Usaha Berdasarkan Jenis Pelanggan</h2>

            <div class="row">
                @php
                    $pelanggan = [
                        'R1', 'R2', 'R3',
                        'B1', 'B2', 'B3',
                        'I2', 'I3', 'I4'
                    ];
                @endphp

                @foreach($pelanggan as $jenis)
                    @php
                        $bebanVar = 'totalBiayaBeban' . $jenis;
                        $pemakaianVar = 'totalBiayaPemakaian' . $jenis;
                        $total = ($$bebanVar ?? 0) + ($$pemakaianVar ?? 0);
                    @endphp

                    <!-- Biaya Beban -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-warning shadow-lg rounded-4 h-100">
                            <div class="card-header bg-warning text-white text-center fw-bold">
                                Biaya Beban {{ $jenis }}
                            </div>
                            <div class="card-body text-center">
                                <h3 class="text-warning">Rp {{ number_format($$bebanVar ?? 0, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Biaya Pemakaian -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-primary shadow-lg rounded-4 h-100">
                            <div class="card-header bg-primary text-white text-center fw-bold">
                                Biaya Pemakaian {{ $jenis }}
                            </div>
                            <div class="card-body text-center">
                                <h3 class="text-primary">Rp {{ number_format($$pemakaianVar ?? 0, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-dark shadow-lg rounded-4 h-100">
                            <div class="card-header bg-dark text-white text-center fw-bold">
                                Total Pendapatan {{ $jenis }}
                            </div>
                            <div class="card-body text-center">
                                <h3 class="text-dark">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div> <!-- End Content -->
</div>

@endsection
