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
    protected static ?string $model = Pemakaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('noPemakaian')
                    ->label('No Pemakaian')
                    ->required(),
                    
                Forms\Components\TextInput::make('meter_awal')
                    ->label('Meter Awal')
                    ->numeric()
                    ->required(),
                    
                Forms\Components\TextInput::make('meter_akhir')
                    ->label('Meter Akhir')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => 
                        $set('jumlah_pakai', max(0, $state - (int) $get('meter_awal')))
                    ),
                    
                Forms\Components\TextInput::make('jumlah_pakai')
                    ->label('Jumlah Pakai')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false), // Tidak disimpan ke database karena hanya perhitungan
                
                Forms\Components\TextInput::make('biaya_beban_pemakai') // Sesuaikan dengan nama di database
                    ->label('Biaya Beban')
                    ->numeric()
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
                Tables\Columns\TextColumn::make('biaya_beban_pemakai')->label('Biaya Beban'),
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
