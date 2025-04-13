<?php

namespace App\Filament\Resources\PelangganResource\Pages;

use App\Filament\Resources\PelangganResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePelanggan extends CreateRecord
{
    protected static string $resource = PelangganResource::class;
    protected function getCreateFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Simpan Data') // Label untuk tombol utama "Create"
                ->createAnotherLabel('Simpan & Tambah Lagi'), // Label untuk "Create and Create Another"
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // Redirect ke halaman daftar pelanggan setelah create
    }
}
