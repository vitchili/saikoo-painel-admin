<?php

namespace App\Policies;

use App\Models\Lembrete;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LembretePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return ! $user->hasRole('Cliente');
    }
}
