<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class GerenciadorArquivos extends Page
{
    public static function canAccess(): bool
    {
        return ! auth()->user()->hasRole('Cliente');
    }
    
    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static string $view = 'filament.pages.gerenciador-arquivos';

    protected static ?string $navigationGroup = 'Gerais';
}
