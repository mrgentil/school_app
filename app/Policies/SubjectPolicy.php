<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;

class SubjectPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['Super Administrateur', 'Administrateur']);
    }

    public function view(User $user, Subject $subject): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur' &&
               $user->school_id === $subject->school_id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role->name, ['Super Administrateur', 'Administrateur']);
    }

    public function update(User $user, Subject $subject): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur' &&
               $user->school_id === $subject->school_id;
    }

    public function delete(User $user, Subject $subject): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur' &&
               $user->school_id === $subject->school_id;
    }
}
