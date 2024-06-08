<?php

namespace App\Filament\Resources\ContatoPessoaClienteResource\Pages;

use App\Filament\Resources\ContatoPessoaClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContatoPessoaCliente extends EditRecord
{
    protected static string $resource = ContatoPessoaClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
