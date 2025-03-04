<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelangganResource\Pages;
use App\Models\Pelanggan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;

class PelangganResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return 'Data Pelanggan';
    }
    public static function getPluralModelLabel(): string
    {
        return ' Data Pelanggan';
    }
    protected function getCreateButtonLabel(): string
    {
        return 'Buat Data Pelanggan';
    }
    protected static ?string $model = Pelanggan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group'; // Icon menu di sidebar

    /**
     * Form untuk Create/Edit Data
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('noKontrol')
                    ->label('No Kontrol')
                    ->required()
                    ->unique(Pelanggan::class, 'noKontrol'),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Pelanggan')
                    ->required(),
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat'),
                Forms\Components\TextInput::make('telepon')
                    ->label('Telepon')
                    ->tel(), // Format telepon
                Forms\Components\Select::make('jenis_plg')
                    ->label('Jenis Pelanggan')
                    ->options([
                        'R-1' => 'R-1',
                        'R-2' => 'R-2',
                        'R-3' => 'R-3',
                        'B-1' => 'B-1',
                        'B-2' => 'B-2',
                        'B-3' => 'B-3',
                        'I-2' => 'I-2',
                        'I-3' => 'I-3',
                        'I-4' => 'I-4',
                    ])
                    ->required(),
            ]);
    }

    /**
     * Konfigurasi Table untuk Menampilkan Data
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('noKontrol')
                    ->label('No Kontrol')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Pelanggan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat'),
                Tables\Columns\TextColumn::make('telepon')
                    ->label('Telepon'),
                Tables\Columns\TextColumn::make('jenis_plg')
                    ->label('Jenis Pelanggan')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime(),
            ])
            ->filters([])
            ->emptyStateHeading('Tidak ada data pelanggan')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    /**
     * Halaman CRUD Filament
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPelanggans::route('/'),
            'create' => Pages\CreatePelanggan::route('/create'),
            'edit' => Pages\EditPelanggan::route('/{record}/edit'),
        ];
    }
}
