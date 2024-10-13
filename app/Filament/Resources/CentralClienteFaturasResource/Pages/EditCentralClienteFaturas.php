<?php

namespace App\Filament\Resources\CentralClienteFaturasResource\Pages;

use App\Filament\Resources\CentralClienteFaturasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCentralClienteFaturas extends EditRecord
{
    protected static string $resource = CentralClienteFaturasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
