<?php

namespace App\Observers;

use App\Gateway\Bitpag\ClienteBitPag;
use App\Models\Cliente\Cliente;
use App\Services\NotificacaoExceptionGeralService;

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
        
    }

    /**
     * Handle the Cliente "updating" event.
     */
    public function updating(Cliente $cliente): void
    {
        $tornarClienteOriginal = $cliente->getOriginal('tornar_cliente');
        
        if ($tornarClienteOriginal == 'S'  && $cliente->tornar_cliente == 'N') {
            $cliente->tornar_cliente = 'S';
            new NotificacaoExceptionGeralService('Impossível retirar a marcação de "Tornar Cliente" do cliente.');
        }

        if ($tornarClienteOriginal == 'N' && $cliente->tornar_cliente == 'S') {
            $ultimoCliente = Cliente::whereNotNull('codigo')->orderBy('codigo', 'desc')->first();
            $cliente->codigo = ! empty($ultimoCliente->codigo) ? ($ultimoCliente->codigo + 1) : 1;
            $cliente->codico = ! empty($ultimoCliente->codigo) ? ($ultimoCliente->codigo + 1) : 1;
        }
    }

    /**
     * Handle the Cliente "deleted" event.
     */
    public function updated(Cliente $cliente): void
    {
        $bitpagIdOriginal = $cliente->getOriginal('cliente_bitpag_id');

        if ($cliente->tornar_cliente == 'S' && empty($bitpagIdOriginal)) {
            $bitPagCliente = new ClienteBitPag();
            $bitPagCliente->cadastrarCliente($cliente);
        }
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
