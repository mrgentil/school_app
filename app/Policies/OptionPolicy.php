<?php

namespace App\Policies;

use App\Models\Option;
use App\Models\User;

class OptionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canManageOptions();
    }

    public function view(User $user, Option $option): bool
    {
        if ($user->canManageAllOptions()) {
            return true;
        }

        return $user->canManageOwnOptions() && $option->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->canManageOptions();
    }

    public function update(User $user, Option $option): bool
    {
        if ($user->canManageAllOptions()) {
            return true;
        }

        return $user->canManageOwnOptions() && $option->created_by === $user->id;
    }

    public function delete(User $user, Option $option): bool
    {
        if ($user->canManageAllOptions()) {
            return true;
        }

        return $user->canManageOwnOptions() && $option->created_by === $user->id;
    }
}
