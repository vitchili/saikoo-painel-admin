<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Auth\Access\Response;

class VeiculoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return ! $user->hasRole('Cliente');
    }
}
