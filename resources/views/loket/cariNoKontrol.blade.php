@extends('layouts.app')
@section('content')
<style>
    .bg-orange {
        background-color: orange !important;
    }

    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .shadow {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .border {
        border-radius: 5px;
    }

    .card-detail {
        margin-right: 214px;
        padding: 1px 1px 1px 3px;
        border: 2px dashed orange;
        border-radius: 10px;
        color: orange;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .card-detail:hover {
        background-color: orange;
        color: white;
        transition: background-color 0.5s ease, color 0.5s ease;
    }
</style>

<body class="">
    <h2 class="mb-4">Cari Data Pemakaian</h2>
    <form action="{{ route('pemakaian') }}" method="GET" class="mb-4">
        <div class="input-group"><input type="text" name="no_kontrol" class="form-control"
                placeholder="Masukkan No Kontrol" value="{{ request('no_kontrol') }}"><button type="submit"
                class="btn bg-orange">Cari</button></div>
    </form>
    @if (isset($noKontrol))
        @if ($pemakaian->isEmpty())
            <p class="text-danger">Tidak ada data pemakaian untuk no kontrol ini.</p>
        @else
            <div class="row">
                @foreach ($pemakaian as $p)
                    <div class="col-md-4">
                        <div class="card mb-3 card-hover shadow" style="cursor: pointer;"
                            onclick="showDetail('{{ $p->noPemakaian }}')">
                            <div class="card-body">
                                <h5 class="card-title">No Pemakaian: {{ $p->noPemakaian }}</h5>
                                <p class="card-text">Meter Awal: {{ $p->meter_awal }} KWH</p>
                                <p class="card-text">Meter Akhir: {{ $p->meter_akhir }} KWH</p>
                                <p class="card-text">Jumlah Pakai: <strong>{{ $p->jumlah_pakai }}</strong> KWH</p>
                                <p class="card-detail"><small>Klik untuk detail</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-orange text-white">
                    <h5 class="modal-title" id="modalLabel">Kwitansi Pembayaran Pemakaian Listrik</h5><button
                        type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="font-family: 'Courier New', Courier, monospace;">
                    <div class="border border-dark p-3 rounded" id="kwitansiContent">
                        <div class="d-flex justify-content-between align-items-start mb-3"><img
                                src="{{ asset('img/logo_pln.jpg') }}" alt="Logo PLN" style="width: 80px; height: auto;">
                            <div class="ms-3 flex-grow-1">
                                <p><strong>Status:</strong><span id="detailStatus" class="badge bg-danger"></span>
                                </p>
                                <p><strong>No Pemakaian:</strong><span id="detailNoPemakaian"></span></p>
                                <p><strong>No Kontrol:</strong><span id="detailNoKontrol"></span></p>
                            </div>
                            <div id="qrcode"></div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <p>Meter Awal: <span id="detailMeterAwal"></span>KWH</p>
                                <p>Meter Akhir: <span id="detailMeterAkhir"></span>KWH</p>
                                <p>Jumlah Pakai: <strong><span id="detailJumlahPakai"></span></strong> KWH</p>
                            </div>
                            <div class="col-md-6">
                                <p>Biaya Beban: Rp <span id="detailBiayaBeban"></span></p>
                                <p>Biaya Pemakaian: Rp <span id="detailBiayaPemakai"></span></p>
                                <p><strong>Total Biaya: Rp <span id="detailTotalBiaya"></span></strong></p>
                            </div>
                        </div>
                        <hr>
                        <p class="text-center fst-italic">Terima kasih telah melakukan pembayaran. Simpan kwitansi
                            ini sebagai bukti pembayaran yang sah. Jika ada kesalahan laporkan ke nomor 58%</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between"><button type="button" class="btn btn-outline-dark"
                        onclick="generatePDF()">Cetak PDF</button><button type="button" class="btn btn-success"
                        id="btnUbahStatus" onclick="updateStatus()">Ubah Status ke Sudah Lunas</button></div>
            </div>
        </div>
    </div>
    <script>
        let selectedNoPemakaian = null;

        function showDetail(noPemakaian) {
            $.ajax({
                url: '{{ url('/pemakaian') }}/' + noPemakaian,
                type: 'GET',
                success: function(data) {
                    selectedNoPemakaian = data.noPemakaian;
                    $('#detailNoPemakaian').text(data.noPemakaian);
                    $('#detailNoKontrol').text(data.noKontrol);
                    $('#detailMeterAwal').text(data.meter_awal);
                    $('#detailMeterAkhir').text(data.meter_akhir);
                    $('#detailJumlahPakai').text(data.jumlah_pakai);

                    const biayaBeban = parseFloat(data.biaya_beban_pemakai);
                    const biayaPemakai = parseFloat(data.biaya_pemakai);
                    const total = biayaBeban + biayaPemakai;

                    $('#detailBiayaBeban').text(new Intl.NumberFormat('id-ID').format(biayaBeban));
                    $('#detailBiayaPemakai').text(new Intl.NumberFormat('id-ID').format(biayaPemakai));
                    $('#detailTotalBiaya').text(new Intl.NumberFormat('id-ID').format(total));

                    $('#detailStatus').text(data.status)
                        .removeClass('bg-danger bg-success')
                        .addClass(data.status === 'Sudah Lunas' ? 'bg-success' : 'bg-danger');

                    if (data.status === 'Sudah Lunas') {
                        $('#btnUbahStatus').hide();
                    } else {
                        $('#btnUbahStatus').show();
                    }

                    $('#qrcode').empty();
                    new QRCode(document.getElementById("qrcode"), {
                        text: data.noPemakaian,
                        width: 80,
                        height: 80
                    });

                    $('#detailModal').modal('show');
                }
            });
        }

        function updateStatus() {
            $.post('{{ route('pemakaian.update-status') }}', {
                _token: '{{ csrf_token() }}',
                noPemakaian: selectedNoPemakaian
            }, function(response) {
                alert(response.message);
                $('#detailStatus').text('Sudah Lunas').removeClass('bg-danger').addClass('bg-success');
            });
        }

        async function generatePDF() {
            const {
                jsPDF
            } = window.jspdf;
            const modalBody = document.getElementById("kwitansiContent");

            const canvas = await html2canvas(modalBody, {
                scale: 2,
                useCORS: true
            });

            const imgData = canvas.toDataURL("image/png");
            const pdf = new jsPDF("p", "mm", "a4");

            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

            pdf.addImage(imgData, "PNG", 10, 10, pdfWidth - 20, pdfHeight);
            pdf.save(`kwitansi-${selectedNoPemakaian}.pdf`);
        }
    </script>
</body>
@endsection
