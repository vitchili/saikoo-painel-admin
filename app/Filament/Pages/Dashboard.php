<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Widgets\ChamadosConcluidosWidget;
use App\Filament\Pages\Widgets\QuantidadeChamadosGeraisSuporteTi;
use App\Filament\Pages\Widgets\QuantidadeChamadosSuporteTi;
use App\Models\Chamado\Chamado;
use App\Models\Cliente\Cliente;
use App\Models\VersaoSistema;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    public const TIPO_CHAMADO_INTERNO = 1;
    public const TIPO_CHAMADO_INTERNO_COM_CLIENTE = 2;
    public const TIPO_CHAMADO_EXTERNO = 3;

    public array $chamadosInternos;
    public array $chamadosExternos;
    public array $versao;
    public array $clientesImplantacao;
    public array $chamadosDiasSemana;

    public $tipo_chamado_id = 1;
    public $dataInicio = '';
    public $dataFim = '';

    public function mount()
    {
        if (empty($this->dataInicio)) {
            $this->dataInicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        }

        if (empty($this->dataFim)) {
            $this->dataFim = Carbon::now()->endOfMonth()->format('Y-m-d');
        }
        
        $this->versao = VersaoSistema::with('tickets')->orderBy('cadastrado_em', 'desc')->first()->toArray();
        $this->versao['data_disponivel'] = Carbon::parse($this->versao['data_disponivel'])->format('d/m/Y');
        $this->versao['tickets'][0]['cadastrado_em'] = Carbon::parse($this->versao['tickets'][0]['cadastrado_em'])->format('d/m/Y');

        $this->clientesImplantacao = Cliente::where('em_implantacao', 'N')
            ->when($this->dataInicio, function ($query) {
                return $query->where('data_cadastro', '>=', $this->dataInicio);
            })
            ->when($this->dataFim, function ($query) {
                return $query->where('data_cadastro', '<=', $this->dataFim);
            })
            ->get()
            ->toArray();

        $this->chamadosDiasSemana = $this->contabilizarChamadosDiasSemana();
    }

    public function contabilizarChamadosDiasSemana(): array
    {
        $totalChamados = Chamado::count();
        
        if (in_array($this->tipo_chamado_id, [1, 2])) {
            $tipo_chamado = [1, 2];
        }else {
            $tipo_chamado = [3];
        }


        $estatisticas = Chamado::select(
            DB::raw('DAYOFWEEK(cadastrado_em) as dia_da_semana'),
            DB::raw('SUM(CASE WHEN TIME(cadastrado_em) < "13:00:00" THEN 1 ELSE 0 END) as antes_13'),
            DB::raw('SUM(CASE WHEN TIME(cadastrado_em) >= "13:00:00" THEN 1 ELSE 0 END) as depois_13')
        )
            ->whereIn('tipo_chamado_id', $tipo_chamado)
            ->when($this->dataInicio, function ($query) {
                return $query->where('cadastrado_em', '>=', $this->dataInicio);
            })
            ->when($this->dataFim, function ($query) {
                return $query->where('cadastrado_em', '<=', $this->dataFim);
            })
            ->groupBy('dia_da_semana')
            ->orderBy('dia_da_semana')
            ->get();

        $resultados = [];
        foreach ($estatisticas as $estatistica) {
            $diasSemana = [
                1 => 'Domingo',
                2 => 'Segunda-Feira',
                3 => 'Terça-Feira',
                4 => 'Quarta-Feira',
                5 => 'Quinta-Feira',
                6 => 'Sexta-Feira',
                7 => 'Sábado',
            ];

            $dia = $diasSemana[$estatistica->dia_da_semana];
            $totalPorDia = $estatistica->antes_13 + $estatistica->depois_13;
            $totalAntes13 = $estatistica->antes_13;
            $totalDepois13 = $estatistica->depois_13;

            $resultados[$estatistica->dia_da_semana] = [
                'dia' => $dia,
                'antes_13' => $estatistica->antes_13,
                'depois_13' => $estatistica->depois_13,
                'total' => $totalPorDia,
                'total_antes_13' => $totalAntes13,
                'total_depois_13' => $totalDepois13,
                'percentual' => $totalChamados > 0 ? ($totalPorDia / $totalChamados) * 100 : 0,
            ];
        }

        $output = [
            2 => [
                "dia" => "Segunda-feira",
                "antes_13" => $resultados[2]["antes_13"] ?? 0,
                "depois_13" => $resultados[2]["depois_13"] ?? 0,
                "total" => $resultados[2]["total"] ?? 0,
                "total_antes_13" => $resultados[2]["total_antes_13"] ?? 0,
                "total_depois_13" => $resultados[2]["total_depois_13"] ?? 0,
                "percentual" => $resultados[2]["percentual"] ?? 0
            ],
            3 => [
                "dia" => "Terça-feira",
                "antes_13" => $resultados[3]["antes_13"] ?? 0,
                "depois_13" => $resultados[3]["depois_13"] ?? 0,
                "total" => $resultados[3]["total"] ?? 0,
                "total_antes_13" => $resultados[3]["total_antes_13"] ?? 0,
                "total_depois_13" => $resultados[3]["total_depois_13"] ?? 0,
                "percentual" => $resultados[3]["percentual"] ?? 0
            ],
            4 => [
                "dia" => "Quarta-feira",
                "antes_13" => $resultados[4]["antes_13"] ?? 0,
                "depois_13" => $resultados[4]["depois_13"] ?? 0,
                "total" => $resultados[4]["total"] ?? 0,
                "total_antes_13" => $resultados[4]["total_antes_13"] ?? 0,
                "total_depois_13" => $resultados[4]["total_depois_13"] ?? 0,
                "percentual" => $resultados[4]["percentual"] ?? 0
            ],
            5 => [
                "dia" => "Quinta-feira",
                "antes_13" => $resultados[5]["antes_13"] ?? 0,
                "depois_13" => $resultados[5]["depois_13"] ?? 0,
                "total" => $resultados[5]["total"] ?? 0,
                "total_antes_13" => $resultados[5]["total_antes_13"] ?? 0,
                "total_depois_13" => $resultados[5]["total_depois_13"] ?? 0,
                "percentual" => $resultados[5]["percentual"] ?? 0
            ],
            6 => [
                "dia" => "Sexta-feira",
                "antes_13" => $resultados[6]["antes_13"] ?? 0,
                "depois_13" => $resultados[6]["depois_13"] ?? 0,
                "total" => $resultados[6]["total"] ?? 0,
                "total_antes_13" => $resultados[6]["total_antes_13"] ?? 0,
                "total_depois_13" => $resultados[6]["total_depois_13"] ?? 0,
                "percentual" => $resultados[6]["percentual"] ?? 0
            ],
            7 => [
                "dia" => "Sábado",
                "antes_13" => $resultados[7]["antes_13"] ?? 0,
                "depois_13" => $resultados[7]["depois_13"] ?? 0,
                "total" => $resultados[7]["total"] ?? 0,
                "total_antes_13" => $resultados[7]["total_antes_13"] ?? 0,
                "total_depois_13" => $resultados[7]["total_depois_13"] ?? 0,
                "percentual" => $resultados[7]["percentual"] ?? 0
            ]
        ];

        return $output;
    }

    public function pesquisar(): void
    {
        $this->mount();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ChamadosConcluidosWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            QuantidadeChamadosSuporteTi::class,
            QuantidadeChamadosGeraisSuporteTi::class,
        ];
    }
}
