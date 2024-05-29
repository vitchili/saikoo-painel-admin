<?php

namespace App\Filament\Resources\MeioAberturaResource\Pages;

use App\Filament\Resources\MeioAberturaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMeioAbertura extends EditRecord
{
    protected static string $resource = MeioAberturaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
