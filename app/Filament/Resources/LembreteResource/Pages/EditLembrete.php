<?php

namespace App\Filament\Resources\LembreteResource\Pages;

use App\Filament\Resources\LembreteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLembrete extends EditRecord
{
    protected static string $resource = LembreteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
