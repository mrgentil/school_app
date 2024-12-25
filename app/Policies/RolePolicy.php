<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('Super Administrateur');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasRole('Super Administrateur');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Super Administrateur');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasRole('Super Administrateur');
    }

    public function delete(User $user, Role $role): bool
    {
        if ($role->name === 'Super Administrateur') {
            return false;
        }
        return $user->hasRole('Super Administrateur');
    }
}
