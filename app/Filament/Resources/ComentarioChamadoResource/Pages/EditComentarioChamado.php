<?php

namespace App\Filament\Resources\ComentarioChamadoResource\Pages;

use App\Filament\Resources\ComentarioChamadoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComentarioChamado extends EditRecord
{
    protected static string $resource = ComentarioChamadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
