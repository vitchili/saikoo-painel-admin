<?php

namespace App\Filament\Resources\AtaReuniaoResource\Pages;

use App\Filament\Resources\AtaReuniaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAtaReuniaos extends ListRecords
{
    protected static string $resource = AtaReuniaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
