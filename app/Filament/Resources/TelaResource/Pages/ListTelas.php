<?php

namespace App\Filament\Resources\TelaResource\Pages;

use App\Filament\Resources\TelaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTelas extends ListRecords
{
    protected static string $resource = TelaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
