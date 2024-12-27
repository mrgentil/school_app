<?php

namespace App\Services;

use App\Models\Option;

class OptionService
{
    public function getOptionsList($currentUser, $filters = [])
    {
        $query = Option::with(['school']); // Assurez-vous d'avoir la relation school définie dans le modèle

        // Si l'utilisateur est administrateur, ne montrer que les options de son école
        if ($currentUser->hasRole('Administrateur')) {
            $query->whereHas('school', function($q) use ($currentUser) {
                $q->where('id', $currentUser->school_id);
            });
        }

        // Recherche par nom d'option
        if (!empty($filters['name'])) {
            $query->where('name', 'LIKE', "%{$filters['name']}%");
        }

        // Recherche par nom d'école
        if (!empty($filters['school'])) {
            $query->whereHas('school', function($q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters['school']}%");
            });
        }

        return $query->latest()->paginate(15);
    }

    public function store(array $data, $user)
    {
        return Option::create([
            'name' => $data['name'],
            'school_id' => $data['school_id'],
            'created_by' => $user->id
        ]);
    }

    public function update(Option $option, array $data)
    {
        $option->update($data);
        return $option;
    }

    public function delete(Option $option)
    {
        return $option->delete();
    }
}
