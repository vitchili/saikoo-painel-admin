<?php

namespace App\Console\Commands;

use App\Gateway\Bitpag\CobrancaBitpag;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\Enum\StatusFaturaCliente;
use App\Models\Cliente\Fatura\Enum\StatusPagamentoBitPag;
use App\Models\Cliente\Fatura\FaturaCliente;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BatimentoCobrancasBitPag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:realizar-batimento-cobrancas-bitpag';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consultar cobranças na BitPag e realizar baixas e informativos de atraso.';

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

        $bitpag = new CobrancaBitpag();

        
        foreach ($clientes as $cliente) {
            $response = $bitpag->consultarCobrancas(1, ['search' => $cliente->nome]);
            $qtdPaginas = $response['last_page'];

            for($i = 1; $i <= $qtdPaginas; $i++) {
                $response = $bitpag->consultarCobrancas($i, ['search' => $cliente->nome]);

                foreach($response['data'] as $cobranca){
                    $faturaEquivalente = FaturaCliente::where('cobranca_bitpag_id', $cobranca['hash_id'])->first();

                    if ($faturaEquivalente) {
                        $this->atualizarStatus($faturaEquivalente, $cobranca['payments'][0]['status'], $cobranca['payments'][0]['amount_paid'], $cobranca['payments'][0]['paid_at']);
                    }
                }
            }
        }
    }

    public function atualizarStatus(FaturaCliente $fatura, string $status, string $valorPago, string $dataPagamento): void
    {
        switch ($status) {
            case StatusPagamentoBitPag::PROCESSANDO->value:
                $statusFatura = StatusFaturaCliente::AGUARDANDO_PAGAMENTO->value;
                break;
            case StatusPagamentoBitPag::PENDENTE->value:
                $statusFatura = StatusFaturaCliente::AGUARDANDO_PAGAMENTO->value;
                break;
            case StatusPagamentoBitPag::PAGO->value:
                $statusFatura = StatusFaturaCliente::APROVADO->value;
                $fatura->valor_pago = floatval($valorPago);
                $fatura->data_alt_status = Carbon::createFromFormat('d/m/Y H:i', $dataPagamento)->format('Y-m-d H:i:s');
                break;
            case StatusPagamentoBitPag::ERRO->value:
                $statusFatura = StatusFaturaCliente::ERRO->value;
                break;
            case StatusPagamentoBitPag::CANCELANDO->value:
                $statusFatura = StatusFaturaCliente::CANCELADO->value;
                break;
            case StatusPagamentoBitPag::CANCELADO->value:
                $statusFatura = StatusFaturaCliente::CANCELADO->value;
                break;
            case StatusPagamentoBitPag::ATRASADO->value:
                $statusFatura = StatusFaturaCliente::INADIMPLENTE->value;
                break;
            case StatusPagamentoBitPag::ESTORNADO->value:
                $statusFatura = StatusFaturaCliente::ERRO->value;
                break;
            case StatusPagamentoBitPag::CONTESTADO->value:
                $statusFatura = StatusFaturaCliente::ERRO->value;
                break;
            default:
                throw new \Exception('Status de pagamento bitpag não encontrado. Fatura ' . $fatura->id);
        }
        

        $fatura->status_pagamento_bitpag = $status;
        $fatura->status = $statusFatura;

        $fatura->save();
    }
}