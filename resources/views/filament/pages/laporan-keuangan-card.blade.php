<div class="grid grid-cols-3 gap-6">
    @foreach ($jenisPelangganList as $jenis)
        @php
            $key = str_replace('-', '', $jenis); // Format variabel
        @endphp
        <div class="col-span-1">
            <x-filament::card>
                <x-slot name="header">
                    <h2>{{ $jenis }}</h2>
                </x-slot>
                <div class="space-y-2">
                    <p><strong>Total Biaya Pemakaian:</strong> Rp {{ number_format($data["totalBiayaPemakaian$key"], 0, ',', '.') }}</p>
                    <p><strong>Total Biaya Beban:</strong> Rp {{ number_format($data["totalBiayaBeban$key"], 0, ',', '.') }}</p>
                </div>
            </x-filament::card>
        </div>
    @endforeach
</div>
