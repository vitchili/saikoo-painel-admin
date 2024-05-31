<?php

namespace App\Filament\Resources\TipoRedeSocialClienteResource\Pages;

use App\Filament\Resources\TipoRedeSocialClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoRedeSocialCliente extends EditRecord
{
    protected static string $resource = TipoRedeSocialClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
