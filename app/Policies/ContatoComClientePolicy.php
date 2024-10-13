<?php

namespace App\Policies;

use App\Models\ContatoComCliente;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContatoComClientePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return ! $user->hasRole('Cliente');
    }
}
