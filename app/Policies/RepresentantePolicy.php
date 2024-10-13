<?php

namespace App\Policies;

use App\Models\Representante;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RepresentantePolicy
{
   /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return ! $user->hasRole('Cliente');
    }
}
