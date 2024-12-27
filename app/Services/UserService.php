<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\{User, Role, School};
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Access\AuthorizationException;

class UserService
{
    /**
     * Récupère la liste des utilisateurs selon les droits
     */
    public function getUsersList($currentUser, array $filters = [])
    {
        $query = User::with(['role', 'school']);

        // Si l'utilisateur est administrateur, filtrer par école
        if ($currentUser->hasRole('Administrateur')) {
            $query->where('school_id', $currentUser->school_id);
        }

        // Appliquer les filtres de recherche
        if (!empty($filters['id'])) {
            $query->where('id', 'LIKE', "%{$filters['id']}%");
        }

        if (!empty($filters['name'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters['name']}%")
                  ->orWhere('first_name', 'LIKE', "%{$filters['name']}%")
                  ->orWhere('last_name', 'LIKE', "%{$filters['name']}%");
            });
        }

        if (!empty($filters['school'])) {
            $query->whereHas('school', function ($q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters['school']}%");
            });
        }

        return $query->latest()->paginate(15);
    }

    /**
     * Récupère les données pour les formulaires
     */
    public function getFormData($currentUser)
    {
        if ($currentUser->hasRole('Super Administrateur')) {
            return [
                Role::all(),
                School::all()
            ];
        }

        return [
            Role::where('name', '!=', 'Super Administrateur')->get(),
            School::where('id', $currentUser->school_id)->get()
        ];
    }

    /**
     * Crée un nouvel utilisateur
     */
    public function createUser($request, $currentUser)
    {
        $user = new User($request->validated());
        $user->password = Hash::make('password');
        $user->created_by = $currentUser->id;

        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();
        return $user;
    }

    /**
     * Valide la création d'un utilisateur selon les droits de l'utilisateur courant
     *
     * @param array $data
     * @param User $currentUser
     * @return void
     * @throws AuthorizationException
     */
    public function validateUserCreation(array $data, User $currentUser): void
    {
        // Vérifie si l'utilisateur est un administrateur d'école
        if ($currentUser->hasRole('Administrateur')) {
            // Vérifie que l'école sélectionnée correspond à celle de l'administrateur
            if ($data['school_id'] != $currentUser->school_id) {
                throw new AuthorizationException(
                    'Vous ne pouvez créer des utilisateurs que pour votre école.'
                );
            }

            // Vérifie que le rôle n'est pas Super Administrateur
            $role = Role::find($data['role_id']);
            if ($role && $role->name === 'Super Administrateur') {
                throw new AuthorizationException(
                    'Vous ne pouvez pas créer d\'utilisateur avec le rôle Super Administrateur.'
                );
            }
        }
        // Si c'est un Super Administrateur, pas de validation supplémentaire nécessaire
    }

    /**
     * Met à jour un utilisateur
     *
     * @param User $user
     * @param UserRequest $request
     * @param User $currentUser
     * @return User
     */
    public function updateUser(User $user, $request, User $currentUser): User
    {
        // Validation des droits
        if ($currentUser->hasRole('Administrateur')) {
            if ($request->school_id != $currentUser->school_id) {
                throw new AuthorizationException(
                    'Vous ne pouvez modifier que les utilisateurs de votre école.'
                );
            }

            $role = Role::find($request->role_id);
            if ($role && $role->name === 'Super Administrateur') {
                throw new AuthorizationException(
                    'Vous ne pouvez pas assigner le rôle de Super Administrateur.'
                );
            }
        }

        // Mise à jour des données
        $user->fill($request->validated());

        // Gestion de l'avatar si présent
        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return $user;
    }

    /**
     * Supprime un utilisateur
     *
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function deleteUser(User $user): bool
    {
        try {
            // Vérifier si l'utilisateur n'est pas le dernier Super Admin
            if ($user->hasRole('Super Administrateur')) {
                $superAdminCount = User::whereHas('role', function ($query) {
                    $query->where('name', 'Super Administrateur');
                })->count();

                if ($superAdminCount <= 1) {
                    throw new \Exception('Impossible de supprimer le dernier Super Administrateur.');
                }
            }

            // Supprimer l'avatar si existe
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Supprimer l'utilisateur
            return $user->delete();

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de l\'utilisateur: ' . $e->getMessage(), [
                'user_id' => $user->id
            ]);
            throw $e;
        }
    }

}
