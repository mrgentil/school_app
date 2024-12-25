<?php

namespace App\Policies;

use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Super Administrateur', 'Administrateur']);
    }

    public function view(User $user, School $school): bool
    {
        if ($user->hasRole('Super Administrateur')) {
            return true;
        }

        return $user->hasRole('Administrateur') && $user->school_id === $school->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Super Administrateur');
    }

    public function update(User $user, School $school): bool
    {
        if ($user->hasRole('Super Administrateur')) {
            return true;
        }

        return $user->hasRole('Administrateur') && $user->school_id === $school->id;
    }

    public function delete(User $user, School $school): bool
    {
        return $user->hasRole('Super Administrateur');
    }
}
