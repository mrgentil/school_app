<?php

namespace App\Policies;

use App\Models\Promotion;
use App\Models\User;

class PromotionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canManagePromotions();
    }

    public function view(User $user, Promotion $promotion): bool
    {
        if ($user->canManageAllPromotions()) {
            return true;
        }

        return $user->canManageOwnPromotions() && $promotion->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->canManagePromotions();
    }

    public function update(User $user, Promotion $promotion): bool
    {
        if ($user->canManageAllPromotions()) {
            return true;
        }

        return $user->canManageOwnOptions() && $promotion->created_by === $user->id;
    }

    public function delete(User $user, Promotion $promotion): bool
    {
        if ($user->canManageAllPromotions()) {
            return true;
        }

        return $user->canManageOwnOptions() && $promotion->created_by === $user->id;
    }
}
