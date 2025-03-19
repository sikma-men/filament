<?php

namespace App\Filament\Resources\DataAkunLoketResource\Pages;

use App\Filament\Resources\DataAkunLoketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataAkunLoket extends EditRecord
{
    protected static string $resource = DataAkunLoketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
