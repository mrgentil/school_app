<?php

namespace App\Traits;

trait HasOptionPermissions
{
    public function canManageAllOptions(): bool
    {
        return $this->hasRole('Super Administrateur');
    }


    public function canManageOwnOptions(): bool
    {
        return $this->hasRole('Administrateur');
    }

    public function canManageOptions(): bool
    {
        return $this->canManageAllOptions() || $this->canManageOwnOptions();
    }
}
