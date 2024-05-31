<?php

namespace App\Filament\Resources\TipoContatoPessoaClienteResource\Pages;

use App\Filament\Resources\TipoContatoPessoaClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipoContatoPessoaClientes extends ListRecords
{
    protected static string $resource = TipoContatoPessoaClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
