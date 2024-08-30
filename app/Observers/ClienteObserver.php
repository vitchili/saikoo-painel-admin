<?php

namespace App\Observers;

use App\Gateway\Bitpag\ClienteBitPag;
use App\Models\Cliente\Cliente;

class ClienteObserver
{
    /**
     * Handle the Cliente "creating" event.
     */
    public function creating(Cliente $cliente): void
    {
    
    }

    /**
     * Handle the Cliente "created" event.
     */
    public function created(Cliente $cliente): void
    {
        $bitPagCliente = new ClienteBitPag();
        $bitPagCliente->cadastrarCliente($cliente);
    }

    /**
     * Handle the Cliente "updating" event.
     */
    public function updating(Cliente $cliente): void
    {
        $tornarClienteOriginal = $cliente->getOriginal('tornar_cliente');

        if ($tornarClienteOriginal == 'N' && $cliente->tornar_cliente == 'S') {
            $cliente->codigo++;
            $cliente->codico++;
            $cliente->tornar_cliente = 'S';
        }

        $bitpagIdOriginal = $cliente->getOriginal('cliente_bitpag_id');

        if (empty($bitpagIdOriginal)) {
            $bitPagCliente = new ClienteBitPag();
            $bitPagCliente->cadastrarCliente($cliente);
        }
    }

    /**
     * Handle the Cliente "deleted" event.
     */
    public function deleted(Cliente $cliente): void
    {
        //
    }

    /**
     * Handle the Cliente "restored" event.
     */
    public function restored(Cliente $cliente): void
    {
        //
    }

    /**
     * Handle the Cliente "force deleted" event.
     */
    public function forceDeleted(Cliente $cliente): void
    {
        //
    }
}
