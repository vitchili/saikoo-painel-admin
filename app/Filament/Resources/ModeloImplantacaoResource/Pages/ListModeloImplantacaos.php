<?php

namespace App\Filament\Resources\ModeloImplantacaoResource\Pages;

use App\Filament\Resources\ModeloImplantacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModeloImplantacaos extends ListRecords
{
    protected static string $resource = ModeloImplantacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
