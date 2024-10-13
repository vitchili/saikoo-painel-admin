<?php

namespace App\Filament\Resources\CentralClienteSerialResource\Pages;

use App\Filament\Resources\CentralClienteSerialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCentralClienteSerials extends ListRecords
{
    protected static string $resource = CentralClienteSerialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
