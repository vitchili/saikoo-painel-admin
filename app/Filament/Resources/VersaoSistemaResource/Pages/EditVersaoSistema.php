<?php

namespace App\Filament\Resources\VersaoSistemaResource\Pages;

use App\Filament\Resources\VersaoSistemaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVersaoSistema extends EditRecord
{
    protected static string $resource = VersaoSistemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
