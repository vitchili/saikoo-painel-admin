<?php

namespace App\Observers;

use App\Models\Cliente\Cliente;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Parallax\FilamentComments\Models\FilamentComment;

class FilamentCommentObserver
{
    /**
     * Handle the FilamentComment "created" event.
     */
    public function creating(FilamentComment $filamentComment): void
    {
        $user = User::find($filamentComment->user_id);

        $cliente = Cliente::find($user->cliente_id);

        if ($filamentComment->subject_type == 'App\Models\Cliente\Fatura\FaturaCliente') {
            $faturaCliente = $filamentComment->subject_type::find($filamentComment->subject_id);
            
            $users = User::whereDoesntHave('roles', function($query) {
                $query->where('name', 'Cliente');
            })->get();

            Notification::make()
            ->title("O cliente {$cliente->nome} enviou um comentário na fatura de vencimento ". Carbon::parse($faturaCliente->vencimento)->format('d/m/Y'))
            ->sendToDatabase($users);
        }

    }

    /**
     * Handle the FilamentComment "updated" event.
     */
    public function updated(FilamentComment $filamentComment): void
    {
        //
    }

    /**
     * Handle the FilamentComment "deleted" event.
     */
    public function deleted(FilamentComment $filamentComment): void
    {
        //
    }

    /**
     * Handle the FilamentComment "restored" event.
     */
    public function restored(FilamentComment $filamentComment): void
    {
        //
    }

    /**
     * Handle the FilamentComment "force deleted" event.
     */
    public function forceDeleted(FilamentComment $filamentComment): void
    {
        //
    }
}
