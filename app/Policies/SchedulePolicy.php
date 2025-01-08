<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;

class SchedulePolicy
{
    /**
     * Déterminer si l'utilisateur peut voir la liste des horaires.
     */
    public function viewAny(User $user): bool
    {
        // Seuls le Super Administrateur et l'Administrateur peuvent voir les horaires
        return in_array($user->role->name, ['Super Administrateur', 'Administrateur']);
    }

    /**
     * Déterminer si l'utilisateur peut voir un horaire spécifique.
     */
    public function view(User $user, Schedule $schedule): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true; // Le Super Administrateur peut voir tous les horaires
        }

        if ($user->role->name === 'Administrateur') {
            // L'Administrateur peut voir les horaires liés à son école uniquement
            return $schedule->class->school_id === $user->school_id;
        }

        return false; // Les autres rôles ne peuvent pas voir les horaires
    }

    /**
     * Déterminer si l'utilisateur peut créer un horaire.
     */
    public function create(User $user): bool
    {
        // Seuls le Super Administrateur et l'Administrateur peuvent créer des horaires
        return in_array($user->role->name, ['Super Administrateur', 'Administrateur']);
    }

    /**
     * Déterminer si l'utilisateur peut modifier un horaire.
     */
    public function update(User $user, Schedule $schedule): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true; // Le Super Administrateur peut modifier tous les horaires
        }

        if ($user->role->name === 'Administrateur') {
            // L'Administrateur peut modifier les horaires liés à son école uniquement
            return $schedule->class->school_id === $user->school_id;
        }

        return false; // Les autres rôles ne peuvent pas modifier les horaires
    }

    /**
     * Déterminer si l'utilisateur peut supprimer un horaire.
     */
    public function delete(User $user, Schedule $schedule): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true; // Le Super Administrateur peut supprimer tous les horaires
        }

        if ($user->role->name === 'Administrateur') {
            // L'Administrateur peut supprimer les horaires liés à son école uniquement
            return $schedule->class->school_id === $user->school_id;
        }

        return false; // Les autres rôles ne peuvent pas supprimer les horaires
    }
}
