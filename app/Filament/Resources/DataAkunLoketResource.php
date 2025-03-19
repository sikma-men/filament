<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataAkunLoketResource\Pages;
use App\Filament\Resources\DataAkunLoketResource\RelationManagers;
use App\Models\Loket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataAkunLoketResource extends Resource
{
    protected static ?string $model = Loket::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataAkunLokets::route('/'),
            'create' => Pages\CreateDataAkunLoket::route('/create'),
            'edit' => Pages\EditDataAkunLoket::route('/{record}/edit'),
        ];
    }
}
