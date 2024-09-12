<?php

namespace App\Filament\Resources\ConfiguracaoReajustesMassaResource\Pages;

use App\Filament\Resources\ConfiguracaoReajustesMassaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConfiguracaoReajustesMassa extends EditRecord
{
    protected static string $resource = ConfiguracaoReajustesMassaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
