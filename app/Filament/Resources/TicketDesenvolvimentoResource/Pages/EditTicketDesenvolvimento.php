<?php

namespace App\Filament\Resources\TicketDesenvolvimentoResource\Pages;

use App\Filament\Resources\TicketDesenvolvimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicketDesenvolvimento extends EditRecord
{
    protected static string $resource = TicketDesenvolvimentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
