<?php

namespace App\Services;

use App\Models\School;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;

class SchoolService
{
    /**
     * Récupère les écoles selon les droits de l'utilisateur
     */
    public function getSchoolsList($currentUser, $filters = [])
    {
        $query = School::query();

        // Si l'utilisateur est administrateur, ne montrer que son école
        if ($currentUser->hasRole('Administrateur')) {
            $query->where('id', $currentUser->school_id);
        }

        // Appliquer le filtre de recherche par nom
        if (!empty($filters['name'])) {
            $query->where('name', 'LIKE', "%{$filters['name']}%");
        }

        return $query->latest()->paginate(15);
    }

    /**
     * Crée une nouvelle école
     */
    public function createSchool(array $validatedData): School
    {
        try {
            if (isset($validatedData['logo'])) {
                $validatedData['logo'] = $this->handleLogoUpload($validatedData['logo']);
            }

            return School::create($validatedData);
        } catch (\Exception $e) {
            Log::error('Erreur création école: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Met à jour une école
     */
    public function updateSchool(School $school, array $validatedData): School
    {
        try {
            if (isset($validatedData['logo'])) {
                // Supprimer l'ancien logo
                if ($school->logo) {
                    Storage::disk('public')->delete($school->logo);
                }
                $validatedData['logo'] = $this->handleLogoUpload($validatedData['logo']);
            }

            $school->update($validatedData);
            return $school;
        } catch (\Exception $e) {
            Log::error('Erreur modification école: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Supprime une école
     */
    public function deleteSchool(School $school): bool
    {
        try {
            if ($school->users()->count() > 0) {
                throw new AuthorizationException('Cette école ne peut pas être supprimée car elle contient des utilisateurs.');
            }

            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }

            return $school->delete();
        } catch (\Exception $e) {
            Log::error('Erreur suppression école: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gère l'upload du logo
     */
    private function handleLogoUpload($logo): string
    {
        return $logo->store('logos', 'public');
    }

    /**
     * Recherche des écoles
     */
    public function searchSchools(array $criteria, $user): Collection
    {
        $query = School::query();

        if ($user->hasRole('Administrateur')) {
            $query->where('id', $user->school_id);
        }

        if (isset($criteria['name'])) {
            $query->where('name', 'like', '%' . $criteria['name'] . '%');
        }

        if (isset($criteria['address'])) {
            $query->where('adress', 'like', '%' . $criteria['address'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
