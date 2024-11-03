<?php

namespace App\Console\Commands;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\Enum\StatusFaturaCliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Serial\SerialCliente;
use App\Models\Cliente\Servico\Enum\PeriodicidadeServico;
use App\Models\Cliente\Servico\ServicoCliente;
use App\Models\ConfiguracaoReajusteMassa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Filament\Notifications\Notification;

class RenovarFaturasAposUmAno extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:renovar-faturas-apos-um-ano';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica se há faturas com a última parcela para o mês atual e renova com reajuste.';

    protected ConfiguracaoReajusteMassa $configuracaoReajuste;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->configuracaoReajuste = ConfiguracaoReajusteMassa::with(['igpm', 'indiceCorrecaoGenerica'])->first();

        $clientes = Cliente::with(['faturas'])->get();

        foreach ($clientes as $cliente) {
            if (empty($cliente->faturas->toArray())) {
                continue;
            }

            foreach ($cliente->faturas as $fatura) {
                if (
                    Carbon::parse(now())->format('Y-m-d') == Carbon::parse($fatura->vencimento)->format('Y-m-d') &&
                    $fatura->servicos[0]->periodicidade != PeriodicidadeServico::NENHUM->value &&
                    $fatura->incremento_parcela == $fatura->qtd &&
                    empty(
                        FaturaCliente::where('id_cliente', $fatura->id_cliente)
                        ->where('referencia', $fatura->referencia)
                        ->where('vencimento', Carbon::parse($fatura->vencimento)->addYear()->format('Y-m-d'))
                        ->first()
                    )
                ) {
                    $this->renovar($fatura);
                }
            }
        }
    }

    public function renovar(FaturaCliente $faturaOriginal)
    {
        $servicosId = [];

        foreach ($faturaOriginal->servicos as $servico) {
            $servicosId[] = $servico['id'];
        }

        $fatura = new FaturaCliente([
            "vencimento" => Carbon::parse($faturaOriginal['vencimento'])->addMonthsNoOverflow((int) 12 / $faturaOriginal['qtd'])->toDateString(),
            "valor" => (float) $faturaOriginal['valor'] * (
                100 + (float) $this->configuracaoReajuste->indiceCorrecaoGenerica?->valor + (float) $this->configuracaoReajuste->igpm?->valor
            ) / 100,
            "servicos" => $servicosId,
            "qtd" => $faturaOriginal['qtd'],
            "info_add" => $faturaOriginal['info_add'],
            "formapagamento" => $faturaOriginal['formapagamento'],
            "obs" => $faturaOriginal['obs'],
            "url_checkout" => $faturaOriginal['url_checkout'],
            "gerar_serial" => false,
            "id_cliente" => $faturaOriginal['id_cliente'],
            //"incremento_parcela" => $faturaOriginal['incremento_parcela'],
        ]);

        if ($faturaOriginal->gerar_serial) {
            $serial = new SerialCliente();
            $serial->id_cliente = $fatura->id_cliente;
            $serial->vencimento_serial = $fatura->vencimento;
            $serial->save();
            $fatura->serial = $serial->serial;
        }

        $fatura->save();

        $users = User::whereNull('cliente_id')->get();
        foreach ($users as $user) {
            Notification::make()
                ->title("
                        <div style='
                            display: flex;
                            align-items: center;
                            background-color: #e0f7e0;
                            color: #006400;
                            border: 1px solid #004d00;
                            padding: 15px;
                            border-radius: 8px;
                        '>
                            <div>
                                <h2 style='margin: 0; font-weight: 700;'>Plano renovado</h2>
                                <a href='". env('APP_URL') ." /admin/clientes/{$fatura->cliente->id}'><p style='margin: 5px 0 0 0;'>O cliente {$fatura->cliente->nome} teve seu plano renovado automaticamente.</p></a>
                            </div>
                        </div>
                        ")
                ->sendToDatabase($user);
        }
    }
}
