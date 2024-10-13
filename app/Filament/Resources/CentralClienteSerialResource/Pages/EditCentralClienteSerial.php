<?php

namespace App\Filament\Resources\CentralClienteSerialResource\Pages;

use App\Filament\Resources\CentralClienteSerialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCentralClienteSerial extends EditRecord
{
    protected static string $resource = CentralClienteSerialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
