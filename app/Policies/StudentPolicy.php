<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['Super Administrateur', 'Administrateur']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Student $student): bool
    {
        // Super Admin peut tout voir
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        // Admin ne peut voir que les étudiants de son école
        if ($user->role->name === 'Administrateur') {
            return $student->school_id === $user->school_id;
        }

        // Les autres rôles n'ont pas accès
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role->name, ['Super Administrateur', 'Administrateur']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Student $student): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur' && $student->school_id === $user->school_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Student $student): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur' && $student->school_id === $user->school_id;
    }

    public function viewHistory(User $user, Student $student): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur' && $student->school_id === $user->school_id;
    }
}
