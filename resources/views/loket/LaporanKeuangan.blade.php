@extends('layouts.app') {{-- Atau sesuaikan dengan layout kamu --}}

@section('content')
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
                <div class="card-header bg-success text-white">Total Biaya Pemakaian</div>
                <div class="card-body">
                    <h3 class="card-title text-success">
                        Rp {{ number_format($totalbiaya, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
