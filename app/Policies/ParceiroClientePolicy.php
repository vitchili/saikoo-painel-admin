<?php

namespace App\Policies;

use App\Models\ParceiroCliente;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ParceiroClientePolicy
{
   /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return ! $user->hasRole('Cliente');
    }
}
