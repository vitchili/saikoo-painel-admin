<?php

namespace App\Filament\Resources\ContatoComClienteResource\Pages;

use App\Filament\Resources\ContatoComClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContatoComClientes extends ListRecords
{
    protected static string $resource = ContatoComClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
