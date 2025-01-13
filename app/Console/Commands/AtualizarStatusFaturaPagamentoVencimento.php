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
        $clientes = Cliente::with(['faturas' => function ($query) {
            $query->whereIn('status', ['Aguardando Pagto', 'Em aberto', 'Inadimplente']);
        }])->get();

        foreach ($clientes as $cliente) {
            foreach ($cliente->faturas as $fatura) {
                $updatedFatura = FaturaCliente::findOrFail($fatura->id);
                if ($updatedFatura->formapagamento == 'Cartão de crédito') {
                    continue;
                }

                if (! empty($fatura->deleted_at)) {
                    $updatedFatura->status = StatusFaturaCliente::CANCELADO->value;
                    $updatedFatura->save();
                    continue;
                }

                if (! empty($fatura->valor_pago)) {
                    $updatedFatura->status = StatusFaturaCliente::APROVADO->value;
                    $updatedFatura->save();
                    continue;
                }
                
                if (
                    (! empty($fatura->vencimento_boleto) && Carbon::parse($fatura->vencimento_boleto)
                        ->lt(Carbon::parse(now()->format('Y-m-d'))) &&
                        empty($fatura->valor_pago)) ||

                    (empty($fatura->vencimento_boleto) && Carbon::parse($fatura->vencimento)
                        ->lt(Carbon::parse(now()->format('Y-m-d'))) &&
                        empty($fatura->valor_pago))
                ) {
                    $updatedFatura->status = StatusFaturaCliente::INADIMPLENTE->value;
                    $this->calcularJurosMulta($fatura);
                    $updatedFatura->save();
                    continue;
                }

                if (
                    ! empty($fatura->cobranca_bitpag_id) &&
                    Carbon::parse($fatura->vencimento)
                    ->gt(Carbon::parse(now()->format('Y-m-d'))) &&
                    empty($fatura->valor_pago)
                ) {
                    $updatedFatura->status = StatusFaturaCliente::AGUARDANDO_PAGAMENTO->value;
                    $updatedFatura->save();
                    continue;
                }

                if (empty($fatura->cobranca_bitpag_id) && Carbon::parse($fatura->vencimento)->gt(Carbon::parse(now()->format('Y-m-d'))) && empty($fatura->valor_pago)) {
                    $updatedFatura->status = StatusFaturaCliente::EM_ABERTO->value;
                    $updatedFatura->save();
                }
            }
        }
    }

    public function calcularJurosMulta(FaturaCliente $fatura): void
    {
        $dataVencimento = \Carbon\Carbon::createFromFormat('Y-m-d', $fatura->vencimento);
        $hoje = \Carbon\Carbon::now();

        $diasAtraso = $dataVencimento->diffInDays($hoje) > 0 ? $dataVencimento->diffInDays($hoje) : 0;

        $juros = (float) $fatura->juros_atraso ?? 0;
        $multa = (float) $fatura->multa_atraso ?? 0;
        $valorOriginal = $fatura->valor ?? 0;

        $valorJuros = $valorOriginal * ($juros / 100);
        $valorMulta = $valorOriginal * ($multa / 100);

        $valorAtualizado = $valorOriginal + $valorJuros * ($diasAtraso / 30) + $valorMulta;

        if ($valorAtualizado != $fatura->valor_atualizado) {
            $fatura->valor_atualizado = (float) number_format($valorAtualizado, 2);
            $fatura->save();
        }
    }
}
