<?php

namespace App\Traits;

trait HasClassPermissions
{
    public function canManageAllClasses(): bool
    {
        return $this->hasRole('Super Administrateur');
    }

    public function canManageOwnClasses(): bool
    {
        return $this->hasRole('Administrateur');
    }

    public function canManageClasses(): bool
    {
        return $this->canManageAllClasses() || $this->canManageOwnClasses();
    }
}
