<?php

namespace App\Filament\Resources\ContatoComClienteResource\Pages;

use App\Filament\Resources\ContatoComClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContatoComCliente extends EditRecord
{
    protected static string $resource = ContatoComClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
