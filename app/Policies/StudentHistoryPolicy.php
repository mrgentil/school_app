<?php

namespace App\Policies;

use App\Models\StudentHistory;
use App\Models\User;

class StudentHistoryPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['Super Administrateur', 'Administrateur']);
    }

    public function view(User $user, StudentHistory $history): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur'
            && $history->school_id === $user->school_id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role->name, ['Super Administrateur', 'Administrateur']);
    }

    public function update(User $user, StudentHistory $history): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur'
            && $history->school_id === $user->school_id;
    }

    public function delete(User $user, StudentHistory $history): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur'
            && $history->school_id === $user->school_id;
    }
}
