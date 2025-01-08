<?php

namespace App\Services;

use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class ScheduleService
{
    /**
     * Créer un nouvel horaire.
     *
     * @param array $data Données pour la création de l'horaire.
     * @return Schedule L'horaire nouvellement créé.
     */
    public function createSchedule(array $data): Schedule
    {
        $data['created_by'] = Auth::id(); // Associer l'horaire à l'utilisateur connecté.
        return Schedule::create($data);
    }

    /**
     * Mettre à jour un horaire existant.
     *
     * @param Schedule $schedule L'horaire à mettre à jour.
     * @param array $data Données mises à jour.
     * @return Schedule L'horaire mis à jour.
     */
    public function updateSchedule(Schedule $schedule, array $data): Schedule
    {
        $schedule->update($data);
        return $schedule;
    }

    /**
     * Supprimer un horaire.
     *
     * @param Schedule $schedule L'horaire à supprimer.
     * @return void
     */
    public function deleteSchedule(Schedule $schedule): void
    {
        $schedule->delete();
    }

    /**
     * Récupérer les horaires visibles pour l'utilisateur connecté.
     *
     * @return \Illuminate\Support\Collection Les horaires accessibles.
     */
    public function getSchedules()
    {
        $user = Auth::user();

        if ($user->role->name === 'Super Administrateur') {
            // Le Super Administrateur peut voir tous les horaires.
            return Schedule::all();
        }

        if ($user->role->name === 'Administrateur') {
            // L'Administrateur peut voir uniquement les horaires de sa propre école.
            return Schedule::whereHas('class', function ($query) use ($user) {
                $query->where('school_id', $user->school_id);
            })->get();
        }

        // Les autres rôles n'ont pas accès aux horaires.
        return collect();
    }
}
