<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPromotionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['Super Administrateur', 'Administrateur']);
    }

    public function promote(User $user)
    {
        return $user->hasAnyRole(['Super Administrateur', 'Administrateur']);
    }
}
