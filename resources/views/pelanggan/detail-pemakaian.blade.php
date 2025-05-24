@extends('layouts.LayoutPelanggan')
@section('contentpelanggan')
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-3"><strong>Detail Pemakaian</strong></h4>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>No Pemakaian:</strong> {{ $data->noPemakaian }}</p>
                        <p><strong>No Kontrol:</strong> {{ $data->noKontrol }}</p>
                        <p><strong>Meter Awal:</strong> {{ $data->meter_awal }} KWH</p>
                        <p><strong>Meter Akhir:</strong> {{ $data->meter_akhir }} KWH</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Jumlah Pakai:</strong> {{ $data->jumlah_pakai }} KWH</p>
                        <p><strong>Biaya Pemakai:</strong> Rp {{ number_format($data->biaya_pemakai, 0, ',', '.') }}</p>
                        <p><strong>Biaya Beban:</strong> Rp {{ number_format($data->biaya_beban_pemakai, 0, ',', '.') }}</p>
                        <p><strong>Status:</strong>
                            @if ($data->status == 'Sudah Lunas')
                                <span class="badge bg-success">Sudah Lunas</span>
                            @else
                                <span class="badge bg-danger">Belum Lunas</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5>QR Code Pemakaian</h5>
                        <div id="qrcode" style="width: 150px; height: 150px;"></div>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('pemakaian.download', $data->noPemakaian) }}" class="btn btn-primary">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('pelanggan.pemakaian') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const noPemakaian = @json($data->noPemakaian);
            const qrcodeText = `No Pemakaian: ${noPemakaian}`;
            new QRCode(document.getElementById("qrcode"), {
                text: qrcodeText,
                width: 150,
                height: 150
            });
        });
    </script>
@endpush
