<?php

namespace App\Services;

use App\Models\Classe;


class ClassService
{
    public function getClassesList($currentUser, $filters = [])
    {
        $query = Classe::with(['school']); // Assurez-vous d'avoir la relation school définie dans le modèle

        // Si l'utilisateur est administrateur, ne montrer que les classes de son école
        if ($currentUser->hasRole('Administrateur')) {
            $query->whereHas('school', function($q) use ($currentUser) {
                $q->where('id', $currentUser->school_id);
            });
        }

        // Recherche par nom de classe
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
        return Classe::create([
            'name' => $data['name'],
            'school_id' => $data['school_id'],
            'created_by' => $user->id
        ]);
    }

    public function update(Classe $class, array $data)
    {
        $class->update($data);
        return $class;
    }

    public function delete(Classe $class)
    {
        return $class->delete();
    }
}
