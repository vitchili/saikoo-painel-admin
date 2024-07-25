<?php

namespace App\Filament\Resources\TipoProjetoTicketDesenvolvimentoResource\Pages;

use App\Filament\Resources\TipoProjetoTicketDesenvolvimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipoProjetoTicketDesenvolvimentos extends ListRecords
{
    protected static string $resource = TipoProjetoTicketDesenvolvimentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
