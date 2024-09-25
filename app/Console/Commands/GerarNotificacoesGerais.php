<?php

namespace App\Console\Commands;

use App\Models\NotificacaoGeral;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Filament\Notifications\Notification;

class GerarNotificacoesGerais extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gerar-notificacoes-gerais';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerar notificações gerais na data hora indicada.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $notificacoes = NotificacaoGeral::all();
        foreach ($notificacoes as $notificacao) {
            $textoNotificacao = $notificacao->chamado_id ? "Chamado #{$notificacao->chamado_id} \n {$notificacao->descricao}" : $notificacao->descricao;

            if ((
                    Carbon::parse($notificacao->data_hora)->format('Y-m-d H:i') == Carbon::now()->subHours(3)->format('Y-m-d H:i') ||
                    Carbon::parse($notificacao->data_hora)->format('Y-m-d H:i') == Carbon::now()->format('Y-m-d H:i')
                ) && $notificacao->enviado == 0) {
                Notification::make()
                    ->title($textoNotificacao)
                    ->sendToDatabase($notificacao->tecnico);

                $notificacaoModel = NotificacaoGeral::find($notificacao->id);
                $notificacaoModel->enviado = 1;
                $notificacaoModel->save();
            }
        }
    }
}
