<?php

namespace App\Filament\Resources\TelaResource\Pages;

use App\Filament\Resources\TelaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTela extends EditRecord
{
    protected static string $resource = TelaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
