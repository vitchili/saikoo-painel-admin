<?php

namespace App\Filament\Resources\TipoServicoClienteResource\Pages;

use App\Filament\Resources\TipoServicoClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoServicoCliente extends EditRecord
{
    protected static string $resource = TipoServicoClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
