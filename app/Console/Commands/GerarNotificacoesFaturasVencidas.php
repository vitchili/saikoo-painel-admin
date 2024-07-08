<?php

namespace App\Console\Commands;

use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Filament\Notifications\Notification;

class GerarNotificacoesFaturasVencidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gerar-notificacoes-faturas-vencidas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerar notificações diária sobre as faturas vencidas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $faturas = FaturaCliente::all();

        $users = User::all();

        foreach ($faturas as $fatura) {
            foreach ($users as $user) {
                if (Carbon::parse($fatura->vencimento) < now() && empty($fatura->valor_pago)) {
                    Notification::make()
                        ->title("
                        <div style='
                            display: flex;
                            align-items: center;
                            background-color: #ffe5e5;
                            color: #b22222;
                            border: 1px solid #b22222;
                            padding: 15px;
                            border-radius: 8px;
                        '>
                            <div>
                                <h2 style='margin: 0; font-weight: 700;'>Fatura Vencida - <span style='font-weight: 500;'>" . $fatura->cliente->nome . "</span></h2>
                                <p style='margin: 5px 0 0 0;'>Fatura com data de vencimento para " . Carbon::parse($fatura->vencimento)->format('d/m/Y') . " está vencida.</p>
                            </div>
                        </div>
                        ")
                        ->sendToDatabase($user);
                }
            }
        }
    }
}
