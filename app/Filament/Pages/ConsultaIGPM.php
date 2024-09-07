<?php

namespace App\Filament\Pages;

use App\Gateway\ConsultaIndicesIGPM;
use App\Models\Igpm;
use Filament\Pages\Page;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class ConsultaIGPM extends Page
{
    use WithPagination;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string $view = 'filament.pages.consulta-igpm';

    protected static ?string $navigationLabel = 'IGPM';

    protected static ?string $slug = 'consulta-igpm';

    protected static ?string $modelLabel = 'IGPM';

    protected static ?string $title = 'Consulta Índices IGPM';

    protected static ?string $navigationGroup = 'Gerais';

    #[Computed()]
    public function indices()
    {
        return Igpm::orderBy('id', 'desc')->paginate(40);
    }
}
