<?php

namespace App\Observers;

use App\Models\Cliente\Contato\ContatoPessoaCliente;

class ContatoPessoaClienteObserver
{
    /**
     * Handle the ContatoPessoaCliente "created" event.
     */
    public function created(ContatoPessoaCliente $contatoPessoaCliente): void
    {
        //
    }

    public function creating(ContatoPessoaCliente $contatoPessoaCliente): void
    {
        $contatoPessoaCliente->responsavel_id = auth()->user()->id;
        $contatoPessoaCliente->cadastrado_por = auth()->user()->id;
    }

    /**
     * Handle the ContatoPessoaCliente "updated" event.
     */
    public function updated(ContatoPessoaCliente $contatoPessoaCliente): void
    {
        //
    }

    public function updating(ContatoPessoaCliente $contatoPessoaCliente): void
    {
        //
    }

    /**
     * Handle the ContatoPessoaCliente "deleted" event.
     */
    public function deleted(ContatoPessoaCliente $contatoPessoaCliente): void
    {
        //
    }

    /**
     * Handle the ContatoPessoaCliente "restored" event.
     */
    public function restored(ContatoPessoaCliente $contatoPessoaCliente): void
    {
        //
    }

    /**
     * Handle the ContatoPessoaCliente "force deleted" event.
     */
    public function forceDeleted(ContatoPessoaCliente $contatoPessoaCliente): void
    {
        //
    }
}
