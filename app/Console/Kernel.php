<?php

namespace App\Console;

use App\Console\Commands\AtualizarStatusFaturaPagamentoVencimento;
use App\Console\Commands\GerarNotificacoesGerais;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        GerarNotificacoesGerais::class,
        AtualizarStatusFaturaPagamentoVencimento::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:gerar-notificacoes-gerais')->everyMinute();
        $schedule->command('app:atualizar-status-faturas-vencimento')->everyMinute();
        //$schedule->command('app:realizar-batimento-cobrancas-bitpag')->everyMinute();
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
