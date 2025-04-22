@extends('layouts.app')
@section('content')

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .sidebar {
        width: 200px;
        height: 100vh;
        padding-top: 20px;
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: fixed;
        margin-left:-130px;
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
        background-color: #;333
        color: #fff !important;
        transform: scale(1.03);
    }

    .sidebar .nav-link.active {
        background-color: #3a3a3a;
        color: #fff !important;
    }

    .content {
        margin-left: 220px;
        padding: 20px;
        width: 100%;
    }
    .costum-nav-item{
        margin-left:20px;
    }
</style>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar navbar-dark bg-dark">
        <ul class="navbar-nav w-100">
            <li class="nav-item text-center costum-nav-item">
                <a class="nav-link {{ request()->routeIs('laporankeseluruhan') ? 'active' : '' }}" href="{{ route('laporankeseluruhan') }}">
                    Keseluruhan
                </a>
            </li>
            <li class="nav-item text-center costum-nav-item">
                <a class="nav-link {{ request()->routeIs('laporanjenis') ? 'active' : '' }}" href="{{ route('laporanjenis') }}">
                    Berdasarkan<br>Jenis Pelanggan
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <!-- Card 1: Total Biaya Beban -->
                <div class="col-md-4 mb-4">
                    <div class="card border-warning shadow-lg rounded-4" style="min-height: 250px;">
                        <div class="card-header bg-warning text-white text-center fw-bold">
                            Total Biaya Beban
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center text-center">
                            <h3 class="text-warning">
                                Rp {{ number_format($totalBiayaBeban, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Total Biaya Pemakaian -->
                <div class="col-md-4 mb-4">
                    <div class="card border-primary shadow-lg rounded-4" style="min-height: 250px;">
                        <div class="card-header bg-primary text-white text-center fw-bold">
                            Total Biaya Pemakaian
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center text-center">
                            <h3 class="text-primary">
                                Rp {{ number_format($totalBiayaPemakai, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Total Keseluruhan -->
                <div class="col-md-4 mb-4">
                    <div class="card border-dark shadow-lg rounded-4" style="min-height: 250px;">
                        <div class="card-header bg-dark text-white text-center fw-bold">
                            Total Keseluruhan
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center text-center">
                            <h3 class="text-dark">
                                Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Content -->
</div>

@endsection
