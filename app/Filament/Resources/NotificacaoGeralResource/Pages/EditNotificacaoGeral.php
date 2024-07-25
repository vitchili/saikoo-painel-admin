<?php

namespace App\Filament\Resources\NotificacaoGeralResource\Pages;

use App\Filament\Resources\NotificacaoGeralResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNotificacaoGeral extends EditRecord
{
    protected static string $resource = NotificacaoGeralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
