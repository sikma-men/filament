<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanKeuanganResource\Pages;
use App\Models\Pemakaian;
use Filament\Resources\Resource;
use Filament\Widgets\CardWidget;  // Import CardWidget
use Illuminate\Support\Facades\DB;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\DropdownAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Actions\CreateAnotherAction;

class LaporanKeuanganResource extends Resource
{
    protected static ?string $model = Pemakaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form schema jika diperlukan
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom tabel jika diperlukan
            ])
            ->filters([
                // Filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Relations jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporanKeuangans::route('/'),
            'create' => Pages\CreateLaporanKeuangan::route('/create'),
            'edit' => Pages\EditLaporanKeuangan::route('/{record}/edit'),
        ];
    }

    // Tambahkan method untuk menampilkan card
    public static function getWidgets(): array
    {
        return [
            CardWidget::make()
                ->title('Laporan Berdasarkan Jenis Pelanggan')
                ->icon('heroicon-o-document-report')
                ->content(function () {
                    $jenisPelangganList = ['R-1', 'R-2', 'R-3', 'B-1', 'B-2', 'B-3', 'I-2', 'I-3', 'I-4'];

                    $data = [];

                    foreach ($jenisPelangganList as $jenis) {
                        // Format variabel agar sesuai dengan penamaan variabel Blade (misal: R-1 → R1)
                        $key = str_replace('-', '', $jenis);

                        // Hitung total biaya pemakaian
                        $data["totalBiayaPemakaian$key"] = DB::table('pemakaian')
                            ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
                            ->where('pelanggan.jenis_pelanggan', $jenis)
                            ->where('pemakaian.status', 'sudah lunas')
                            ->sum('pemakaian.biaya_pemakai');

                        // Optional: Jika ingin biaya beban juga
                        $data["totalBiayaBeban$key"] = DB::table('pemakaian')
                            ->join('pelanggan', 'pemakaian.noKontrol', '=', 'pelanggan.noKontrol')
                            ->where('pelanggan.jenis_pelanggan', $jenis)
                            ->where('pemakaian.status', 'sudah lunas')
                            ->sum('pemakaian.biaya_beban_pemakai');
                    }

                    // Mengembalikan data ke dalam tampilan card
                    return view('filament.pages.laporan-keuangan-card', compact('data', 'jenisPelangganList'));
                }),
        ];
    }
}
