<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Super Administrateur', 'Administrateur']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->hasRole('Super Administrateur')) {
            return true;
        }

        if ($user->hasRole('Administrateur')) {
            return $user->school_id === $model->school_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Super Administrateur', 'Administrateur']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $currentUser L'utilisateur qui fait la modification
     * @param User $targetUser L'utilisateur à modifier
     * @return bool
     */
    public function update(User $currentUser, User $targetUser): bool
    {
        // Super Admin peut tout modifier
        if ($currentUser->hasRole('Super Administrateur')) {
            return true;
        }

        // Administrateur ne peut modifier que les utilisateurs de son école
        if ($currentUser->hasRole('Administrateur')) {
            return $currentUser->school_id === $targetUser->school_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->hasRole('Super Administrateur')) {
            return true;
        }

        if ($user->hasRole('Administrateur')) {
            return $user->school_id === $model->school_id;
        }

        return false;
    }
}
