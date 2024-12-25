<?php

namespace App\Traits;

use App\Models\Role;

trait HasRoles
{
    /**
     * Vérifie si l'utilisateur a un rôle spécifique
     *
     * @param string|array $roles
     * @return bool
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->role->name === $role;
        }
        return false;
    }

    /**
     * Vérifie si l'utilisateur a l'un des rôles spécifiés
     *
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role->name, $roles);
    }

    /**
     * Vérifie si l'utilisateur a tous les rôles spécifiés
     *
     * @param array $roles
     * @return bool
     */
    public function hasAllRoles(array $roles): bool
    {
        return count(array_diff($roles, [$this->role->name])) === 0;
    }

    /**
     * Relation avec le modèle Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
