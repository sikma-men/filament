<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TarifResource\Pages;
use App\Filament\Resources\TarifResource\RelationManagers;
use App\Models\Tarif;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionsGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TarifResource extends Resource
{
    protected static ?string $model = Tarif::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    public static function getNavigationLabel(): string
    {
        return 'Tarif';
    }
    public static function getPluralModelLabel(): string
    {
        return 'Tarif';
    }
    protected function getCreateButtonLabel(): string
    {
        return 'Buat Tarif';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jenis_pelanggan')
                    ->label('Jenis Pelanggan')
                    ->required(),
                Forms\Components\TextInput::make('biayabeban')
                    ->label('Biaya Beban')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('tarifkwh')
                    ->label('Tarif Per KWH')
                    ->numeric()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenis_pelanggan')
                    ->label('Jenis Pelanggan'),
                Tables\Columns\TextColumn::make('biayabeban')
                    ->label('Biaya Beban'),
                Tables\Columns\TextColumn::make('tarifkwh')
                    ->label('Tarif Per KWH'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTarifs::route('/'),
            'create' => Pages\CreateTarif::route('/create'),
            'edit' => Pages\EditTarif::route('/{record}/edit'),
        ];
    }
}
