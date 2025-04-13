<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemakaianResource\Pages;
use App\Models\Pemakaian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\DropdownAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Actions\CreateAnotherAction;

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

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected function getCreateFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Simpan Data')
                ->CreateAnotherLabel('Simpan Dan Tambah Lagi'),
        ];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Sembunyikan No Pemakaian
                Forms\Components\Hidden::make('noPemakaian'),

                // Input Bulan
                Forms\Components\Select::make('bulan')
                    ->label('Bulan')
                    ->options([
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (callable $set, callable $get) {
                        $noKontrol = $get('noKontrol');
                        $bulan = $get('bulan');
                        $tahun = $get('tahun');

                        if ($noKontrol && $bulan && $tahun) {
                            $set('noPemakaian', $bulan . $tahun . $noKontrol);
                        }
                    }),

                // Input Tahun
                Forms\Components\TextInput::make('tahun')
                    ->label('Tahun')
                    ->numeric()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (callable $set, callable $get) {
                        $noKontrol = $get('noKontrol');
                        $bulan = $get('bulan');
                        $tahun = $get('tahun');

                        if ($noKontrol && $bulan && $tahun) {
                            $set('noPemakaian', $bulan . $tahun . $noKontrol);
                        }
                    }),

                // Input No Kontrol
                Forms\Components\Select::make('noKontrol')
                    ->label('No Kontrol')
                    ->options(\App\Models\Pelanggan::pluck('noKontrol', 'noKontrol'))
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (callable $set, callable $get, $state) {
                        $bulan = $get('bulan');
                        $tahun = $get('tahun');

                        if ($bulan && $tahun && $state) {
                            $set('noPemakaian', $bulan . $tahun . $state);
                        }

                        // Cek pemakaian terakhir berdasarkan noKontrol
                        $lastPemakaian = Pemakaian::where('noKontrol', $state)
                            ->latest('created_at')
                            ->first();

                        $set('meter_awal', $lastPemakaian?->meter_akhir ?? 0);
                    }),

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
                                $set('biaya_pemakai', 0);
                                $set('biaya_beban_pemakai', 0);
                            }
                        } else {
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
    public static function getGloballySearchableAttributes(): array
    {
        return ['noPemakaian', 'noKontrol', 'bulan', 'tahun'];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
    public static function getEloquentModel(): string
    {
        return parent::getEloquentModel();
    }
    public static function getEloquentModelLabel(): string
    {
        return 'Data Pemakaian';
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
                        'Sudah Lunas' => 'success',
                        'Belum Lunas' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
