<?php

namespace App\Observers;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Serial\SerialCliente;
use App\Services\SerialClienteService;
use Carbon\Carbon;

class SerialClienteObserver
{
    /**
     * Handle the SerialCliente "creating" event.
     */
    public function creating(SerialCliente $serialCliente): void
    {
        $servicoSerial = new SerialClienteService(
            cliente: $serialCliente->cliente ?? Cliente::find($serialCliente->id_cliente)->first(), 
            dataVencimento: Carbon::parse($serialCliente->vencimento_serial)->format('dmY')
        );

        $hash = $servicoSerial->gerarSerial();

        $serialCliente->serial = $hash;
        $serialCliente->usuario_gerado = auth()->user()->name;
        $serialCliente->cnpj_serial = $serialCliente->cliente->cpf_cnpj;
        $serialCliente->tipo = 'C';
    }
}
