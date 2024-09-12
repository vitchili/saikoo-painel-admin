<?php

namespace App\Filament\Resources\IndiceCorrecaoGenericoResource\Pages;

use App\Filament\Resources\IndiceCorrecaoGenericoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIndiceCorrecaoGenericos extends ListRecords
{
    protected static string $resource = IndiceCorrecaoGenericoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
