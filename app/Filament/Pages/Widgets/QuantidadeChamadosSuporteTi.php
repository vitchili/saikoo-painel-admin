<?php

namespace App\Filament\Pages\Widgets;

use App\Models\Chamado\Enum\SituacaoChamado;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class QuantidadeChamadosSuporteTi extends ChartWidget
{
    public const ROLE_SUPORTE_TI_ID = 1;

    protected static ?string $heading = 'Andamento do Suporte TI';

    public function getDescription(): ?string
    {
        return 'Quantidade de chamados por funcionário.';
    }

    protected function getData(): array
    {
        $users = User::whereNull('cliente_id')->get();
        $suportes = [];

        foreach ($users as $user) {
            if (! empty($user->roles->toArray()) && $user->roles[0]->id == self::ROLE_SUPORTE_TI_ID) {
                $suportes[] = $user;
            }
        }

        $payload = [];

        foreach ($suportes as $suporte) {
            $totaisChamados = $this->getTotaisSituacoesChamados($suporte->chamados->toArray());

            $payload[] = [
                'label' => $suporte->name,
                'data' => [$totaisChamados[0], $totaisChamados[1], $totaisChamados[2], $totaisChamados[3], $totaisChamados[4]]
            ];
        }

        return [
            'datasets' => $payload,
            'labels' => ['Aberto', 'Confirmado', 'Andamento', 'Concluído', 'Cancelado'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getTotaisSituacoesChamados(array $chamados): array
    {
        $totais = [0,0,0,0,0];

        foreach ($chamados as $chamado) {
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

        return $totais;
    }
}
