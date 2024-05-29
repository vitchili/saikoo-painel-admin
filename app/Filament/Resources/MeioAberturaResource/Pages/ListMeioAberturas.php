<?php

namespace App\Filament\Resources\MeioAberturaResource\Pages;

use App\Filament\Resources\MeioAberturaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMeioAberturas extends ListRecords
{
    protected static string $resource = MeioAberturaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
