<?php

namespace App\Filament\Resources\DataAkunLoketResource\Pages;

use App\Filament\Resources\DataAkunLoketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataAkunLokets extends ListRecords
{
    protected static string $resource = DataAkunLoketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
