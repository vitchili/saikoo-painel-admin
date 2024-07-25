<?php

namespace App\Filament\Resources\NotificacaoGeralResource\Pages;

use App\Filament\Resources\NotificacaoGeralResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotificacaoGerals extends ListRecords
{
    protected static string $resource = NotificacaoGeralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
