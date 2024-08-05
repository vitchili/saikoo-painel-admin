<?php

namespace App\Filament\Pages\Widgets;

use App\Models\Chamado\Chamado;
use App\Models\Chamado\Enum\SituacaoChamado;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ChamadosConcluidosWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalChamados = Chamado::all()->count();
        $totalChamadosConcluidos = Chamado::where('situacao_id', SituacaoChamado::CONCLUIDO)->count();
        $totalChamadosEmAndamento = Chamado::whereIn('situacao_id', [SituacaoChamado::EM_ATENDIMENTO])->count();
        $totalChamadosConfirmados = Chamado::whereIn('situacao_id', [SituacaoChamado::CONFIRMADO])->count();
        $totalChamadosEmAberto = Chamado::whereIn('situacao_id', [SituacaoChamado::ABERTO])->count();
        
        $porcentagemChamadosConcluidos = 0;
        $porcentagemChamadosEmAndamento = 0;
        $porcentagemChamadosConfirmados = 0;
        $porcentagemChamadosEmAberto = 0;

        if($totalChamados > 0) {
            $porcentagemChamadosConcluidos = (float) ((int) $totalChamadosConcluidos * 100 /  (int) $totalChamados);
            $porcentagemChamadosEmAndamento = (float) ((int) $totalChamadosEmAndamento * 100 /  (int) $totalChamados);
            $porcentagemChamadosConfirmados = (float) ((int) $totalChamadosConfirmados * 100 /  (int) $totalChamados);
            $porcentagemChamadosEmAberto = (float) ((int) $totalChamadosEmAberto * 100 /  (int) $totalChamados);
        }

        return [
            Stat::make('Concluídos', $totalChamadosConcluidos)
                ->description("Concluídos: {$porcentagemChamadosConcluidos}%")
                ->descriptionIcon('heroicon-o-check', IconPosition::Before)
                ->chart([1, 30, 5, 40, 20, 30])
                ->color('success'),
            Stat::make('Em andamento', $totalChamadosEmAndamento)
                ->description("Em andamento: {$porcentagemChamadosEmAndamento}%")
                ->descriptionIcon('heroicon-o-clock', IconPosition::Before)
                ->chart([30, 1, 5, 40, 30, 40])
                ->color('warning'),
            Stat::make('Confirmados', $totalChamadosConfirmados)
                ->description("Confirmados: {$porcentagemChamadosConfirmados}%")
                ->descriptionIcon('heroicon-o-clipboard-document-list', IconPosition::Before)
                ->chart([40, 30, 5, 30, 2, 30])
                ->color('info'),
            Stat::make('Em aberto', $totalChamadosEmAberto)
                ->description("Em aberto: {$porcentagemChamadosEmAberto}%")
                ->descriptionIcon('heroicon-o-envelope-open', IconPosition::Before)
                ->chart([1, 6, 5, 8, 2, 3])
                ->color('gray'),
        ];
    }
}
