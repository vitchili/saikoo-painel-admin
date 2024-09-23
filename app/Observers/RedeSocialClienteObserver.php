<?php

namespace App\Observers;

use App\Models\Cliente\RedeSocialCliente;

class RedeSocialClienteObserver
{
    /**
     * Handle the RedeSocialCliente "created" event.
     */
    public function creating(RedeSocialCliente $redeSocialCliente)
    {
        if (empty($redeSocialCliente->tipo_rede_social_id)) {
            return false;
        }
    }

    /**
     * Handle the RedeSocialCliente "updated" event.
     */
    public function updated(RedeSocialCliente $redeSocialCliente): void
    {
        //
    }

    /**
     * Handle the RedeSocialCliente "deleted" event.
     */
    public function deleted(RedeSocialCliente $redeSocialCliente): void
    {
        //
    }

    /**
     * Handle the RedeSocialCliente "restored" event.
     */
    public function restored(RedeSocialCliente $redeSocialCliente): void
    {
        //
    }

    /**
     * Handle the RedeSocialCliente "force deleted" event.
     */
    public function forceDeleted(RedeSocialCliente $redeSocialCliente): void
    {
        //
    }
}
