<?php

namespace App\Filament\Pages\Widgets;

use Filament\Widgets\ChartWidget;

class QuantidadeChamadosSuporteTi extends ChartWidget
{
    protected static ?string $heading = 'Andamento do Suporte TI';

    public function getDescription(): ?string
    {
        return 'Quantidade de chamados por funcionário.';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Vitor',
                    'data' => [0, 10, 5, 2],
                ],
            ],
            'labels' => ['Aberto', 'Confirmado', 'Andamento', 'Concluído'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
