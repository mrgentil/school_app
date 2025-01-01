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

        return $user->canManageOwnPromotions() && $promotion->created_by === $user->id;
    }

    public function delete(User $user, Promotion $promotion): bool
    {
        if ($user->canManageAllPromotions()) {
            return true;
        }

        return $user->canManageOwnPromotions() && $promotion->created_by === $user->id;
    }

    // Nouvelles méthodes pour la promotion des élèves
    public function promoteStudents(User $user): bool
    {
        return $user->canManagePromotions();
    }

    public function viewPromotionHistory(User $user, Promotion $promotion): bool
    {
        if ($user->canManageAllPromotions()) {
            return true;
        }

        // Si c'est un administrateur, il peut voir l'historique des promotions de son école
        if ($user->role->name === 'Administrateur') {
            return $promotion->school_id === $user->school_id;
        }

        return $user->canManageOwnPromotions() && $promotion->created_by === $user->id;
    }

    public function managePromotionStudents(User $user, Promotion $promotion): bool
    {
        if ($user->canManageAllPromotions()) {
            return true;
        }

        // Vérifier si l'utilisateur peut gérer les promotions de son école
        if ($user->role->name === 'Administrateur') {
            return $promotion->school_id === $user->school_id;
        }

        return $user->canManageOwnPromotions() && $promotion->created_by === $user->id;
    }
}
