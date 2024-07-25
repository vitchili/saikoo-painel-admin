<?php

namespace App\Filament\Resources\TelaTopicoModeloImplantacaoResource\Pages;

use App\Filament\Resources\TelaTopicoModeloImplantacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTelaTopicoModeloImplantacao extends EditRecord
{
    protected static string $resource = TelaTopicoModeloImplantacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
