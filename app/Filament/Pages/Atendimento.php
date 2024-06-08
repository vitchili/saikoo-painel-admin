<?php

namespace App\Filament\Pages;

use App\Models\Lembrete\Lembrete;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class Atendimento extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.atendimento';

    protected static ?string $navigationGroup = 'Agenda';

    public array $lembretes;
    // public Chamado $chamado;

    public function mount()
    {
        $this->lembretes = Lembrete::with('criador')->with('tecnicos')->get()->toArray();
    }
}
