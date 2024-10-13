<?php

namespace App\Policies;

use App\Models\FaturaCliente;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FaturaClientePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }
}
