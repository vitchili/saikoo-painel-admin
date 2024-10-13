<?php

namespace App\Filament\Resources\CentralClienteTicketsResource\Pages;

use App\Filament\Resources\CentralClienteTicketsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCentralClienteTickets extends ListRecords
{
    protected static string $resource = CentralClienteTicketsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
