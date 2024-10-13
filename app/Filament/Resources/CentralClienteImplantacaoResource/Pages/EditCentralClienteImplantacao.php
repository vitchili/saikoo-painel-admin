<?php

namespace App\Filament\Resources\CentralClienteImplantacaoResource\Pages;

use App\Filament\Resources\CentralClienteImplantacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCentralClienteImplantacao extends EditRecord
{
    protected static string $resource = CentralClienteImplantacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
