<?php

namespace App\Policies;

use App\Models\TipoContatoComCliente;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TipoContatoComClientePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return ! $user->hasRole('Cliente');
    }
}
