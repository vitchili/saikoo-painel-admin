<?php

namespace App\Filament\Pages\Widgets;

use App\Models\Chamado\Chamado;
use App\Models\Chamado\Enum\SituacaoChamado;
use Filament\Widgets\ChartWidget;

class QuantidadeChamadosGeraisSuporteTi extends ChartWidget
{
    protected static ?string $maxHeight = '270px';

    public const ROLE_SUPORTE_TI_ID = 1;

    protected static ?string $heading = 'Andamento dos atendimentos';

    public function getDescription(): ?string
    {
        return 'Valores em porcentagem (%)';
    }

    protected function getData(): array
    {
        $totais = $this->getTotaisSituacoesChamados();

        return [
            'datasets' => [
                [
                    'data' => [$totais[0], $totais[1], $totais[2], $totais[3], $totais[4]],
                    'backgroundColor' => ['#c4c5d6', '#80b5e8', '#feb822', '#33bea3', '#f5f5f5'],
                ],
            ],
            'labels' => ['Em Aberto', 'Confirmado', 'Em Andamento', 'Concluído', 'Cancelado'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    public function getTotaisSituacoesChamados(): array
    {
        $totais = [0, 0, 0, 0, 0];

        foreach (Chamado::all() as $chamado) {
            if ($chamado['situacao_id'] == SituacaoChamado::ABERTO->value) {
                $totais[0]++;
            }

            if ($chamado['situacao_id'] == SituacaoChamado::CONFIRMADO->value) {
                $totais[1]++;
            }

            if ($chamado['situacao_id'] == SituacaoChamado::EM_ATENDIMENTO->value) {
                $totais[2]++;
            }

            if ($chamado['situacao_id'] == SituacaoChamado::CONCLUIDO->value) {
                $totais[3]++;
            }

            if ($chamado['situacao_id'] == SituacaoChamado::CANCELADO->value) {
                $totais[4]++;
            }
        }

        $somaChamados = $totais[0] + $totais[1] + $totais[2] + $totais[3] + $totais[4];


        $totais[0] = $totais[0] > 0 ? (float) ($totais[0] * 100 / $somaChamados) : 0;
        $totais[1] = $totais[1] > 0 ? (float) ($totais[1] * 100 / $somaChamados) : 0;
        $totais[2] = $totais[2] > 0 ? (float) ($totais[2] * 100 / $somaChamados) : 0;
        $totais[3] = $totais[3] > 0 ? (float) ($totais[3] * 100 / $somaChamados) : 0;
        $totais[4] = $totais[4] > 0 ? (float) ($totais[4] * 100 / $somaChamados) : 0;

        return $totais;
    }
}
