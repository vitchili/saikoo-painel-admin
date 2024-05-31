<?php

namespace App\Filament\Resources\TipoRedeSocialClienteResource\Pages;

use App\Filament\Resources\TipoRedeSocialClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipoRedeSocialClientes extends ListRecords
{
    protected static string $resource = TipoRedeSocialClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
