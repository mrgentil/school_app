<?php

namespace App\Traits;

trait HasPromotionPermissions
{
    public function canManageAllPromotions(): bool
    {
        return $this->hasRole('Super Administrateur');
    }

    public function canManageOwnPromotions(): bool
    {
        return $this->hasRole('Administrateur');
    }

    public function canManagePromotions(): bool
    {
        return $this->canManageAllPromotions() || $this->canManageOwnPromotions();
    }
}
