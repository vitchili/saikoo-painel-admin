<?php

namespace App\Observers;

use App\Models\Cliente\Contato\ContatoComCliente;

class ContatoComClienteObserver
{
    /**
     * Handle the ContatoComCliente "created" event.
     */
    public function created(ContatoComCliente $contatoComCliente): void
    {
        //
    }

    public function creating(ContatoComCliente $contatoComCliente): void
    {
        $contatoComCliente->responsavel_id = auth()->user()->id;
        $contatoComCliente->cadastrado_por = auth()->user()->id;
    }

    /**
     * Handle the ContatoComCliente "updated" event.
     */
    public function updated(ContatoComCliente $contatoComCliente): void
    {
        //
    }

    public function updating(ContatoComCliente $contatoComCliente): void
    {
        //
    }

    /**
     * Handle the ContatoComCliente "deleted" event.
     */
    public function deleted(ContatoComCliente $contatoComCliente): void
    {
        //
    }

    /**
     * Handle the ContatoComCliente "restored" event.
     */
    public function restored(ContatoComCliente $contatoComCliente): void
    {
        //
    }

    /**
     * Handle the ContatoComCliente "force deleted" event.
     */
    public function forceDeleted(ContatoComCliente $contatoComCliente): void
    {
        //
    }
}
