<?php

namespace App\Console\Commands;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\Enum\StatusFaturaCliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AtualizarStatusFaturaPagamentoVencimento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:atualizar-status-faturas-vencimento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consultar cobranças na aplicação e atualizar status caso esteja vencido, gerado, pago etc.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clientes = Cliente::join(
            "faturas_clientes AS fatura",
            "fatura.id_cliente",
            "clientes.id"
          )
            ->whereIn("fatura.status", ["Aguardando Pagto", "Em aberto", "Inadimplente"])
            ->get();

        foreach ($clientes as $cliente) {
            foreach ($cliente->faturas as $fatura) {
                $upatedFatura = FaturaCliente::findOrFail($fatura->id);
                if (Carbon::parse($fatura->vencimento)->lt(now()) && empty($fatura->valor_pago)) {
                    $upatedFatura->status = StatusFaturaCliente::INADIMPLENTE->value;
                    $this->calcularJurosMulta($fatura);
                }

                if (! empty($fatura->cobranca_bitpag_id) && Carbon::parse($fatura->vencimento)->gt(now()) && empty($fatura->valor_pago)) {
                    $upatedFatura->status = StatusFaturaCliente::AGUARDANDO_PAGAMENTO->value;
                }
                
                if (empty($fatura->cobranca_bitpag_id) && Carbon::parse($fatura->vencimento)->gt(now()) && empty($fatura->valor_pago)) {
                    $upatedFatura->status = StatusFaturaCliente::EM_ABERTO->value;
                }
                
                if (! empty($fatura->deleted_at)) {
                    $upatedFatura->status = StatusFaturaCliente::CANCELADO->value;
                }
                
                if (! empty($fatura->valor_pago)) {
                    $upatedFatura->status = StatusFaturaCliente::APROVADO->value;
                }

                $upatedFatura->save();
            }
        }
    }

    public function calcularJurosMulta(FaturaCliente $fatura): void
    {
        $juros = (float) $fatura->juros_atraso ?? 0;
        $multa = (float) $fatura->multa_atraso ?? 0;
        $valorOriginal = $fatura->valor ?? 0;

        $valorJuros = $valorOriginal * ($juros / 100);
        $valorMulta = $valorOriginal * ($multa / 100);

        $valorAtualizado = $valorOriginal + $valorJuros + $valorMulta;

        if ($valorAtualizado != $fatura->valor_atualizado) {
            $fatura->valor_atualizado = (float) number_format($valorAtualizado, 2);
            $fatura->save();
        }
    }
}