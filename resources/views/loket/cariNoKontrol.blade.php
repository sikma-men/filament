@extends('layouts.app')
@section('content')

    <style>
        /* CSS yang kamu punya */
        .bg-orange {
            background-color: orange !important;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: scale(1.01);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-detail {
            margin-top: 10px;
            padding: 2px 6px;
            border: 2px dashed orange;
            border-radius: 10px;
            color: orange;
            transition: 0.5s ease;
            text-align: center;
        }

        .card-detail:hover {
            background-color: orange;
            color: white;
        }

        .filter-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 10px;
        }

        .filter-btn:focus,
        .filter-btn:active {
            outline: none !important;
            box-shadow: none !important;
        }

        .filter-btn {
            position: relative;
            padding: 8px 16px;
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: #333;
        }

        .filter-btn:hover {
            color: orange;
        }

        .filter-btn::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: orange;
            transition: width 0.3s;
        }

        .filter-btn.underline::after {
            width: 100%;
        }

        .filter-btn.noneunderline::after {
            width: 0;
        }

        .filter-btn:hover::after {
            width: 100%;
        }

        .margin {
            margin: 0 160px;
        }
    </style>

    <div class="container my-4">

        <!-- Search Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('loket.pemakaian') }}" method="GET">
                    {{-- ⬇️ Di sini kita set default Sudah Lunas --}}
                    <input type="hidden" name="status" value="{{ request('status') ?? 'Sudah Lunas' }}">
                    <div class="input-group">
                        <input type="text" name="no_kontrol" class="form-control" placeholder="Cari No Kontrol..."
                            value="{{ request('no_kontrol') }}">
                        <button class="btn bg-orange text-white" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="filter-buttons mt-3">
            <button type="button" onclick="filterStatus('Sudah Lunas')"
                class="filter-btn {{ (request('status') ?? 'Sudah Lunas') == 'Sudah Lunas' ? 'underline' : 'noneunderline' }}">
                Sudah Lunas
            </button>
            <div class="margin"></div>
            <button type="button" onclick="filterStatus('Belum Lunas')"
                class="filter-btn {{ (request('status') ?? 'Sudah Lunas') == 'Belum Lunas' ? 'underline' : 'noneunderline' }}">
                Belum Lunas
            </button>
        </div>
        <div class="d-flex align-items-center my-1">
            <hr class="flex-grow-1">
            {{-- <span class="mx-3 text-muted" style="white-space: nowrap;"></span> --}}
            <hr class="flex-grow-1">
        </div>
        <!-- Data Pemakaian -->
        @if (isset($noKontrol))
            @if ($pemakaian->isEmpty())
                <p class="text-danger text-center">Tidak ada data pemakaian untuk No Kontrol ini.</p>
            @else
                <div class="row mt-4">
                    @foreach ($pemakaian as $p)
                        <div class="col-md-4 mb-4">
                            <div class="card card-hover shadow-sm" style="cursor: pointer;"
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

    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="kwitansiArea" style="padding: 20px;">
                <div class="modal-body" style="background: white; position: relative;">
                    <img src="{{ asset('img/logo_pln.jpg') }}" alt="Logo PLN"
                        style="position: absolute; top: 20px; left: 20px; width: 80px; height: auto;">
                    <!-- QR Code -->
                    <div id="qrcode" style="position: absolute; top: 20px; right: 20px;"></div>

                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h4><strong>PEMERINTAH KABUPATEN CIAMIS</strong></h4>
                        <h5>KWITANSI PEMBAYARAN LISTRIK</h5>
                    </div>

                    <!-- Body Content -->
                    <div class="d-flex justify-content-between"
                        style="font-family: 'Courier New', Courier, monospace; font-size: 16px;">
                        <div id="leftDetail" style="width: 48%;"></div>
                        <div id="rightDetail" style="width: 48%;"></div>
                    </div>

                    <div class="text-center mt-4">
                        <small>Terima kasih atas pembayaran Anda.</small>
                    </div>
                </div>

                <!-- Footer tombol download/tutup -->
                <div class="modal-footer">
                    <button onclick="downloadKwitansi()" class="btn btn-success no-print">Download Gambar</button>
                    <button onclick="closeModal()" class="btn btn-danger no-print" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        function showDetail(noPemakaian) {
            fetch(`/detailpemakaian/${noPemakaian}`)
                .then(response => response.json())
                .then(data => {
                    const leftDetail = `
                    <p><strong>No Pemakaian:</strong> ${data.noPemakaian}</p>
                    <p><strong>No Kontrol:</strong> ${data.noKontrol}</p>
                    <p><strong>Meter Awal:</strong> ${data.meter_awal} KWH</p>
                    <p><strong>Meter Akhir:</strong> ${data.meter_akhir} KWH</p>
                `;

                    const rightDetail = `
                    <p><strong>Jumlah Pakai:</strong> ${data.jumlah_pakai} KWH</p>
                    <p><strong>Biaya Pemakai:</strong> Rp ${formatRupiah(data.biaya_pemakai)}</p>
                    <p><strong>Biaya Beban:</strong> Rp ${formatRupiah(data.biaya_beban_pemakai)}</p>
                    <p><strong>Status:</strong> ${data.status}</p>
                `;

                    document.getElementById('leftDetail').innerHTML = leftDetail;
                    document.getElementById('rightDetail').innerHTML = rightDetail;

                    // QR Code
                    document.getElementById('qrcode').innerHTML = "";
                    new QRCode(document.getElementById('qrcode'), {
                        text: data.noPemakaian,
                        width: 80,
                        height: 80
                    });

                    // Show modal
                    const myModal = new bootstrap.Modal(document.getElementById('detailModal'));
                    myModal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengambil data!');
                });
        }

        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function downloadKwitansi() {
            const kwitansiArea = document.getElementById('kwitansiArea');
            const buttons = kwitansiArea.querySelectorAll('.no-print'); // Hide buttons

            buttons.forEach(btn => btn.style.display = 'none'); // Sembunyikan tombol

            html2canvas(kwitansiArea, {
                scale: 2
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'kwitansi_pemakaian_'+ noPemakaian +'.png';
                link.href = canvas.toDataURL('image/png');
                link.click();

                buttons.forEach(btn => btn.style.display = ''); // Tampilkan tombol lagi
            });
        }

        function closeModal() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
            modal.hide();
        }

        function filterStatus(status) {
            // Ubah tampilan tombol sebelum submit
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => btn.classList.remove('underline', 'noneunderline'));

            if (status === 'Sudah Lunas') {
                buttons[0].classList.add('underline');
                buttons[1].classList.add('noneunderline');
            } else if (status === 'Belum Lunas') {
                buttons[0].classList.add('noneunderline');
                buttons[1].classList.add('underline');
            }

            // Update value status dan submit form
            const form = document.querySelector('form');
            form.querySelector('input[name="status"]').value = status;
            form.submit();
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

@endsection
