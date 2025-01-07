<?php

namespace App\Traits;

trait HasProgramPermissions
{
    public function canManageAllPrograms(): bool
    {
        return $this->hasRole('Super Administrateur');
    }

    public function canManageOwnPrograms(): bool
    {
        return $this->hasRole('Administrateur');
    }

    public function canManagePrograms(): bool
    {
        return $this->canManageAllPrograms() || $this->canManageOwnPrograms();
    }
}
