<?php

namespace App\Filament\Pages;

use App\Models\Chamado\Chamado;
use App\Models\Lembrete\Lembrete;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class Atendimento extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.atendimento';

    public array $lembretes;
    public array $chamados;

    public function mount()
    {
        $this->lembretes = Lembrete::with('criador')->with('tecnicos')->get()->toArray();
        $this->chamados = Chamado::with('criador')->with('tecnicos')->whereNotNull('data_visita')->get()->toArray();
    }
}
