<?php

namespace App\Filament\Resources\ContatoPessoaClienteResource\Pages;

use App\Filament\Resources\ContatoPessoaClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContatoPessoaClientes extends ListRecords
{
    protected static string $resource = ContatoPessoaClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
