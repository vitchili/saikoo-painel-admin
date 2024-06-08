<?php

namespace App\Filament\Resources\HistoricoContatoPessoaClienteResource\Pages;

use App\Filament\Resources\HistoricoContatoPessoaClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHistoricoContatoPessoaCliente extends EditRecord
{
    protected static string $resource = HistoricoContatoPessoaClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
