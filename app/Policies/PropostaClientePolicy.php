<?php

namespace App\Policies;

use App\Models\PropostaCliente;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PropostaClientePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return ! $user->hasRole('Cliente');
    }
}
