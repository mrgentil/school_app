<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;

class ProgramPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canManageClasses();
    }

    public function view(User $user, Program $program): bool
    {
        if ($user->canManageAllPrograms()) {
            return true;
        }

        return $user->canManageOwnPrograms() && $program->uploaded_by === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->canManagePrograms();
    }

    public function update(User $user, Program $program): bool
    {
        if ($user->canManageAllPrograms()) {
            return true;
        }

        return $user->canManageOwnPrograms() && $program->uploaded_by === $user->id;
    }

    public function delete(User $user, Program $program): bool
    {
        if ($user->canManageAllPrograms()) {
            return true;
        }

        return $user->canManageOwnPrograms() && $program->uploaded_by === $user->id;
    }
}
