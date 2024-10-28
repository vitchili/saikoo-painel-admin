<?php

namespace App\Console\Commands;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Serial\SerialCliente;
use App\Models\ConfiguracaoReajusteMassa;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
                if (Carbon::parse(now())->format('Y-m-d') == Carbon::parse($fatura->vencimento)->format('Y-m-d')) {
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
        ]);

        if ($fatura->gerar_serial) {
            $serial = new SerialCliente();
            $serial->id_cliente = $fatura->id_cliente;
            $serial->vencimento_serial = $fatura->vencimento;
            $serial->save();
            $fatura->serial = $serial->serial;
        }

        $fatura->save();
    }
}
