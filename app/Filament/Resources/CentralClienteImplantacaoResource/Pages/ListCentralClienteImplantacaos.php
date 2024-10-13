<?php

namespace App\Filament\Resources\CentralClienteImplantacaoResource\Pages;

use App\Filament\Resources\CentralClienteImplantacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCentralClienteImplantacaos extends ListRecords
{
    protected static string $resource = CentralClienteImplantacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
