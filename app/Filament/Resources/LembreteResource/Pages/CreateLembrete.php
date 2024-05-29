<?php

namespace App\Filament\Resources\LembreteResource\Pages;

use App\Filament\Resources\LembreteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLembrete extends CreateRecord
{
    protected static string $resource = LembreteResource::class;

    protected function getRedirectUrl(): string
    {
        return '/admin/atendimento';
    }
}
