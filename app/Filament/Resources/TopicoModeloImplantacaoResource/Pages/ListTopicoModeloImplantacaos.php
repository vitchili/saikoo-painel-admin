<?php

namespace App\Filament\Resources\TopicoModeloImplantacaoResource\Pages;

use App\Filament\Resources\TopicoModeloImplantacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTopicoModeloImplantacaos extends ListRecords
{
    protected static string $resource = TopicoModeloImplantacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
