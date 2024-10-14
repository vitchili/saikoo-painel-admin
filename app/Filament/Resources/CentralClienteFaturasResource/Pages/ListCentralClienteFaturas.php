<?php

namespace App\Filament\Resources\CentralClienteFaturasResource\Pages;

use App\Filament\Resources\CentralClienteFaturasResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListCentralClienteFaturas extends ListRecords
{
    protected static string $resource = CentralClienteFaturasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cadastrarCartao')
            ->label('Meus Cartões')
            ->url(fn () => '/admin/cadastrar-cartao')
            ->icon('heroicon-o-credit-card'),
        ];
    }
}
