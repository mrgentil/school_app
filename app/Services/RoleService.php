<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Auth\Access\AuthorizationException;

class RoleService
{
    /**
     * Récupère tous les rôles
     */
    public function getAllRoles(): Collection
    {
        return Role::orderBy('created_at', 'desc')->get();
    }

    /**
     * Crée un nouveau rôle
     */
    public function createRole(array $validatedData): Role
    {
        return Role::create($validatedData);
    }

    /**
     * Met à jour un rôle
     */
    public function updateRole(Role $role, array $validatedData): Role
    {
        if ($role->name === 'Super Administrateur' && $validatedData['name'] !== 'Super Administrateur') {
            throw new AuthorizationException('Le rôle Super Administrateur ne peut pas être renommé.');
        }

        $role->update($validatedData);
        return $role;
    }

    /**
     * Supprime un rôle
     */
    public function deleteRole(Role $role): bool
    {
        if ($role->name === 'Super Administrateur') {
            throw new AuthorizationException('Le rôle Super Administrateur ne peut pas être supprimé.');
        }

        if ($role->users()->count() > 0) {
            throw new AuthorizationException('Ce rôle ne peut pas être supprimé car il est assigné à des utilisateurs.');
        }

        return $role->delete();
    }
}
