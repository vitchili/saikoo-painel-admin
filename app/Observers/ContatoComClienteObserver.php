<?php

namespace App\Observers;

use App\Models\Cliente\Contato\ContatoComCliente;

class ContatoComClienteObserver
{
    /**
     * Handle the ContatoComCliente "created" event.
     */
    public function created(ContatoComCliente $ContatoComCliente): void
    {
        //
    }

    public function creating(ContatoComCliente $ContatoComCliente): void
    {
        $ContatoComCliente->responsavel_id = auth()->user()->id;
        $ContatoComCliente->cadastrado_por = auth()->user()->id;
    }

    /**
     * Handle the ContatoComCliente "updated" event.
     */
    public function updated(ContatoComCliente $ContatoComCliente): void
    {
        //
    }

    public function updating(ContatoComCliente $ContatoComCliente): void
    {
        //
    }

    /**
     * Handle the ContatoComCliente "deleted" event.
     */
    public function deleted(ContatoComCliente $ContatoComCliente): void
    {
        //
    }

    /**
     * Handle the ContatoComCliente "restored" event.
     */
    public function restored(ContatoComCliente $ContatoComCliente): void
    {
        //
    }

    /**
     * Handle the ContatoComCliente "force deleted" event.
     */
    public function forceDeleted(ContatoComCliente $ContatoComCliente): void
    {
        //
    }
}
