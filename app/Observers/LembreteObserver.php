<?php

namespace App\Observers;

use App\Models\Lembrete\Lembrete;

class LembreteObserver
{
    /**
     * Handle the Lembrete "created" event.
     */
    public function creating(Lembrete $lembrete): void
    {
        $lembrete->criado_por = auth()->user()->id;
    }

    /**
     * Handle the Lembrete "updated" event.
     */
    public function updated(Lembrete $lembrete): void
    {
        //
    }

    /**
     * Handle the Lembrete "deleted" event.
     */
    public function deleted(Lembrete $lembrete): void
    {
        //
    }

    /**
     * Handle the Lembrete "restored" event.
     */
    public function restored(Lembrete $lembrete): void
    {
        //
    }

    /**
     * Handle the Lembrete "force deleted" event.
     */
    public function forceDeleted(Lembrete $lembrete): void
    {
        //
    }
}
