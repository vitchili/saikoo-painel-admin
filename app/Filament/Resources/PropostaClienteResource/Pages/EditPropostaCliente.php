<?php

namespace App\Filament\Resources\PropostaClienteResource\Pages;

use App\Filament\Resources\PropostaClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropostaCliente extends EditRecord
{
    protected static string $resource = PropostaClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
