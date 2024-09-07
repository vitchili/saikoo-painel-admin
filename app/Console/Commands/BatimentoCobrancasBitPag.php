<?php

namespace App\Console\Commands;

use App\Gateway\Bitpag\CobrancaBitpag;
use App\Models\Cliente\Cliente;
use App\Models\Cliente\Fatura\FaturaCliente;
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

        //$bitpag = new CobrancaBitpag();

        foreach ($clientes as $cliente) {
            dd($cliente);
            //$bitpag->consultarCobrancas();
        }

    }
}
