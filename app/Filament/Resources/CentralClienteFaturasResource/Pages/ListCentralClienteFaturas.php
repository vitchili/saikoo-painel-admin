<?php

namespace App\Filament\Resources\CentralClienteFaturasResource\Pages;

use App\Filament\Resources\CentralClienteFaturasResource;
use Filament\Actions;
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
            ->label('Cadastrar Cartão')
            ->modalHeading('Cadastrar Cartão de Crédito')
            ->modalContent(view('filament.pages.cadastrar-cartao'))
            ->modalWidth(MaxWidth::FiveExtraLarge)
            ->action(function () {
                Notification::make()
                    ->success()
                    ->title('Ação realizada com sucesso.')
                    ->send();
            })
            ->icon('heroicon-o-credit-card'),
        ];
    }
}
