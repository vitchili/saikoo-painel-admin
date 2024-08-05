<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Widgets\ChamadosConcluidosWidget;
use App\Models\Chamado\Chamado;
use App\Models\Cliente\Cliente;
use App\Models\VersaoSistema;
use Carbon\Carbon;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    public const TIPO_CHAMADO_INTERNO = 1;
    public const TIPO_CHAMADO_INTERNO_COM_CLIENTE = 2;
    public const TIPO_CHAMADO_EXTERNO = 3;

    public array $chamadosInternos;
    public array $chamadosExternos;
    public array $versoes;
    public array $clientesImplantacao;

    public function mount()
    {
        $this->chamadosInternos = Chamado::with('criador')
            ->with('tecnicos')
            ->where('cadastrado_em', '>=', Carbon::now()->startOfMonth())
            ->where('cadastrado_em', '<', Carbon::now()->endOfMonth())
            ->whereIn('tipo_chamado_id', [self::TIPO_CHAMADO_INTERNO, self::TIPO_CHAMADO_INTERNO_COM_CLIENTE])
            ->get()
            ->toArray();

        $this->chamadosExternos = Chamado::with('criador')
            ->with('tecnicos')
            ->where('cadastrado_em', '>=', Carbon::now()->startOfMonth())
            ->where('cadastrado_em', '<', Carbon::now()->endOfMonth())
            ->where('tipo_chamado_id', self::TIPO_CHAMADO_EXTERNO)
            ->get()
            ->toArray();

        $this->versoes = VersaoSistema::with('tickets')->get()->toArray();

        $this->clientesImplantacao = Cliente::where('em_implantacao', 'N')->get()->toArray();
    }

    protected function getFooterWidgets(): array
    {
        return [
            ChamadosConcluidosWidget::class,
        ];
    }
}
