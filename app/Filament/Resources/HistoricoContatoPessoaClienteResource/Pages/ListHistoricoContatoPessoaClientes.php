<?php

namespace App\Filament\Resources\HistoricoContatoPessoaClienteResource\Pages;

use App\Filament\Resources\HistoricoContatoPessoaClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHistoricoContatoPessoaClientes extends ListRecords
{
    protected static string $resource = HistoricoContatoPessoaClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
