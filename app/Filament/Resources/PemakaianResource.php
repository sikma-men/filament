<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemakaianResource\Pages;
use App\Models\Pemakaian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PemakaianResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return 'Data Pemakaian';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Data Pemakaian';
    }

    protected function getCreateButtonLabel(): string
    {
        return 'Buat Data Pemakaian';
    }

    protected static ?string $model = Pemakaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Sembunyikan No Pemakaian
                Forms\Components\Hidden::make('noPemakaian'),

                // Input No Kontrol
                Forms\Components\Select::make('noKontrol')
                    ->label('No Kontrol')
                    ->options(\App\Models\Pelanggan::pluck('noKontrol', 'noKontrol')) // Ambil data pelanggan
                    ->searchable()
                    ->required()
                    ->live() // Agar bisa digunakan untuk generate otomatis
                    ->afterStateUpdated(
                        fn(callable $set, callable $get) =>
                        $set('noPemakaian', now()->format('mY') . $get('noKontrol'))
                    ),

                // Input Meter Awal
                Forms\Components\TextInput::make('meter_awal')
                    ->label('Meter Awal')
                    ->numeric()
                    ->reactive()
                    ->required(),

                // Input Meter Akhir
                Forms\Components\TextInput::make('meter_akhir')
                    ->label('Meter Akhir')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        // Hitung jumlah_pakai
                        $jumlah_pakai = max(0, $state - (int) $get('meter_awal'));
                        $set('jumlah_pakai', $jumlah_pakai);

                        // Ambil data tarif berdasarkan noKontrol
                        $noKontrol = $get('noKontrol');
                        $pelanggan = \App\Models\Pelanggan::where('noKontrol', $noKontrol)->first();

                        if ($pelanggan) {
                            $tarif = \App\Models\Tarif::where('jenis_pelanggan', $pelanggan->jenis_pelanggan)->first();

                            if ($tarif) {
                                // Hitung biaya pemakaian
                                $biaya_pemakai = $jumlah_pakai * $tarif->tarifkwh;
                                $set('biaya_pemakai', $biaya_pemakai);

                                // Set biaya beban pemakaian
                                $biaya_beban_pemakai = $tarif->biayabeban;
                                $set('biaya_beban_pemakai', $biaya_beban_pemakai);
                            } else {
                                // Jika tarif tidak ditemukan, set nilai default
                                $set('biaya_pemakai', 0);
                                $set('biaya_beban_pemakai', 0);
                            }
                        } else {
                            // Jika pelanggan tidak ditemukan, set nilai default
                            $set('biaya_pemakai', 0);
                            $set('biaya_beban_pemakai', 0);
                        }
                    }),

                // Input Jumlah Pakai (Otomatis)
                Forms\Components\TextInput::make('jumlah_pakai')
                    ->label('Jumlah Pakai')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),

                // Input Biaya Pemakaian (Otomatis)
                Forms\Components\TextInput::make('biaya_pemakai')
                    ->label('Biaya Pemakaian')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),

                // Input Biaya Beban Pemakaian (Otomatis)
                Forms\Components\TextInput::make('biaya_beban_pemakai')
                    ->label('Biaya Beban')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),

                // Input Status
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Lunas' => 'Lunas',
                        'Belum Lunas' => 'Belum Lunas',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('noPemakaian')->label('No Pemakaian'),
                Tables\Columns\TextColumn::make('meter_awal')->label('Meter Awal'),
                Tables\Columns\TextColumn::make('meter_akhir')->label('Meter Akhir'),
                Tables\Columns\TextColumn::make('jumlah_pakai')->label('Jumlah Pakai'),
                Tables\Columns\TextColumn::make('biaya_pemakai')->label('Biaya Pemakaian'),
                Tables\Columns\TextColumn::make('biaya_beban_pemakai')->label('Biaya Beban'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Lunas' => 'success', // Warna hijau untuk status "Lunas"
                        'Belum Lunas' => 'danger', // Warna merah untuk status "Belum Lunas"
                        default => 'gray', // Warna default jika ada nilai lain,
                    }),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPemakaians::route('/'),
            'create' => Pages\CreatePemakaian::route('/create'),
            'edit' => Pages\EditPemakaian::route('/{record}/edit'),
        ];
    }
}
