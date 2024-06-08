<?php

namespace App\Filament\Resources\TipoChamadoResource\Pages;

use App\Filament\Resources\TipoChamadoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipoChamados extends ListRecords
{
    protected static string $resource = TipoChamadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
