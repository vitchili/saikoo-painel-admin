<?php

namespace App\Filament\Resources\TopicoModeloImplantacaoResource\Pages;

use App\Filament\Resources\TopicoModeloImplantacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTopicoModeloImplantacao extends EditRecord
{
    protected static string $resource = TopicoModeloImplantacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
