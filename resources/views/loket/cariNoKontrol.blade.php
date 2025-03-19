<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemakaian</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="container mt-4">
    <h2 class="mb-4">Cari Data Pemakaian</h2>

    <form action="{{ route('pemakaian') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="no_kontrol" class="form-control" placeholder="Masukkan No Kontrol" value="{{ request('no_kontrol') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    @if(isset($noKontrol))
        <h4>Hasil Pencarian untuk No Kontrol: {{ $noKontrol }}</h4>
        @if($pemakaian->isEmpty())
            <p class="text-danger">Tidak ada data pemakaian untuk no kontrol ini.</p>
        @else
            <div class="row">
                @foreach ($pemakaian as $p)
                    <div class="col-md-4">
                        <div class="card mb-3" style="cursor: pointer;" onclick="showDetail('{{ $p->noPemakaian }}')">
                            <div class="card-body">
                                <h5 class="card-title">No Pemakaian: {{ $p->noPemakaian }}</h5>
                                <p class="card-text">Meter Awal: {{ $p->meter_awal }}</p>
                                <p class="card-text">Meter Akhir: {{ $p->meter_akhir }}</p>
                                <p class="card-text">Jumlah Pakai: <strong>{{ $p->jumlah_pakai }}</strong> m³</p>
                                <p class="card-text"><small class="text-muted">Klik untuk detail</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    <!-- Modal Detail Pemakaian -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Detail Pemakaian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>No Pemakaian:</strong> <span id="detailNoPemakaian"></span></p>
                    <p><strong>No Kontrol:</strong> <span id="detailNoKontrol"></span></p>
                    <p><strong>Meter Awal:</strong> <span id="detailMeterAwal"></span></p>
                    <p><strong>Meter Akhir:</strong> <span id="detailMeterAkhir"></span></p>
                    <p><strong>Jumlah Pakai:</strong> <span id="detailJumlahPakai"></span> m³</p>
                    <p><strong>Biaya Beban:</strong> Rp <span id="detailBiayaBeban"></span></p>
                    <p><strong>Biaya Pemakaian:</strong> Rp <span id="detailBiayaPemakai"></span></p>
                    <p><strong>Status:</strong> <span id="detailStatus" class="badge bg-danger"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" id="btnUbahStatus" onclick="updateStatus()">Ubah Status ke Sudah Lunas</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedNoPemakaian = null;

        function showDetail(noPemakaian) {
            $.ajax({
                url: '{{ url("/pemakaian") }}/' + noPemakaian,
                type: 'GET',
                success: function(data) {
                    selectedNoPemakaian = data.noPemakaian;
                    $('#detailNoPemakaian').text(data.noPemakaian);
                    $('#detailNoKontrol').text(data.noKontrol);
                    $('#detailMeterAwal').text(data.meter_awal);
                    $('#detailMeterAkhir').text(data.meter_akhir);
                    $('#detailJumlahPakai').text(data.jumlah_pakai);
                    $('#detailBiayaBeban').text(new Intl.NumberFormat('id-ID').format(data.biaya_beban_pemakai));
                    $('#detailBiayaPemakai').text(new Intl.NumberFormat('id-ID').format(data.biaya_pemakai));
                    $('#detailStatus').text(data.status).removeClass('bg-danger bg-success').addClass(data.status === 'Sudah Lunas' ? 'bg-success' : 'bg-danger');
                    $('#detailModal').modal('show');
                }
            });
        }

        function updateStatus() {
            $.post('{{ route("pemakaian.update-status") }}', {_token: '{{ csrf_token() }}', noPemakaian: selectedNoPemakaian}, function(response) {
                alert(response.message);
                $('#detailStatus').text('Sudah Lunas').removeClass('bg-danger').addClass('bg-success');
            });
        }
    </script>
</body>
</html>
