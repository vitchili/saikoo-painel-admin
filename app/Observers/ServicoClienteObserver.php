<?php

namespace App\Observers;

use App\Models\Cliente\Servico\ServicoCliente;

class ServicoClienteObserver
{
    /**
     * Handle the ServicoCliente "created" event.
     */
    public function creating(ServicoCliente $servicoCliente): void
    {
    }

    /**
     * Handle the ServicoCliente "updated" event.
     */
    public function updated(ServicoCliente $servicoCliente): void
    {
        //
    }

    /**
     * Handle the ServicoCliente "updated" event.
     */
    public function updating(ServicoCliente $servicoCliente): void
    {
        $servicoOriginal = ServicoCliente::find($servicoCliente->id);

        if ($servicoOriginal->versao != $servicoCliente->versao) {
            $servicoCliente->versao_data_atualizado = now();
            $servicoCliente->versao_por_atualizado = auth()->user()->id;
        }
    }

    /**
     * Handle the ServicoCliente "deleted" event.
     */
    public function deleted(ServicoCliente $servicoCliente): void
    {
        //
    }

    /**
     * Handle the ServicoCliente "restored" event.
     */
    public function restored(ServicoCliente $servicoCliente): void
    {
        //
    }

    /**
     * Handle the ServicoCliente "force deleted" event.
     */
    public function forceDeleted(ServicoCliente $servicoCliente): void
    {
        //
    }
}
