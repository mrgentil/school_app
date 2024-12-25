<?php

namespace App\Policies;

use App\Models\Classe;
use App\Models\User;

class ClassPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canManageClasses();
    }

    public function view(User $user, Classe $class): bool
    {
        if ($user->canManageAllClasses()) {
            return true;
        }

        return $user->canManageOwnClasses() && $class->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->canManageClasses();
    }

    public function update(User $user, Classe $class): bool
    {
        if ($user->canManageAllClasses()) {
            return true;
        }

        return $user->canManageOwnClasses() && $class->created_by === $user->id;
    }

    public function delete(User $user, Classe $class): bool
    {
        if ($user->canManageAllClasses()) {
            return true;
        }

        return $user->canManageOwnClasses() && $class->created_by === $user->id;
    }
}
