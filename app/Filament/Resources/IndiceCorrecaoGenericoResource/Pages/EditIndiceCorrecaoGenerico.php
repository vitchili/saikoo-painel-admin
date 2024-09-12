<?php

namespace App\Filament\Resources\IndiceCorrecaoGenericoResource\Pages;

use App\Filament\Resources\IndiceCorrecaoGenericoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIndiceCorrecaoGenerico extends EditRecord
{
    protected static string $resource = IndiceCorrecaoGenericoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
