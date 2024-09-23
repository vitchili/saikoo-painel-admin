<?php

namespace App\Observers;

use App\Models\Cliente\ContatoPessoaCliente;
use Exception;

class ContatoPessoaClienteObserver
{
    /**
     * Handle the ContatoPessoaCliente "created" event.
     */
    public function creating(ContatoPessoaCliente $contatoPessoaCliente)
    {
        if (empty($contatoPessoaCliente->nome)) {
            return false;
        }
    }

    /**
     * Handle the ContatoPessoaCliente "updated" event.
     */
    public function updated(ContatoPessoaCliente $contatoPessoaCliente): void
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
