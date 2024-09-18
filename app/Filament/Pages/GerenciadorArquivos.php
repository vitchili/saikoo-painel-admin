<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class GerenciadorArquivos extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static string $view = 'filament.pages.gerenciador-arquivos';

    protected static ?string $navigationGroup = 'Gerais';
}
