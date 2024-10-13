<?php

namespace App\Policies;

use App\Models\ModeloImplantacao;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ModeloImplantacaoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return ! $user->hasRole('Cliente');
    }
}
