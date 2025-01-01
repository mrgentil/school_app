<?php

namespace App\Services;

use App\Models\Classe;
use App\Models\User;

class ClassService
{
    public function getClassesList($currentUser, $filters = [])
    {
        $query = Classe::with(['school', 'option']);

        if ($currentUser->role->name === 'Administrateur') {
            $query->where('school_id', $currentUser->school_id);
        }

        if (!empty($filters['name'])) {
            $query->where('name', 'LIKE', "%{$filters['name']}%");
        }

        if (!empty($filters['school'])) {
            $query->whereHas('school', function($q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters['school']}%");
            });
        }

        return $query->latest()->paginate(15);
    }

    public function store(array $data, User $user)
{
    return Classe::create([
        'name' => $data['name'],
        'section' => $data['section'],
        'level' => $data['level'] ?? 1,
        'school_id' => $user->role->name === 'Super Administrateur'
            ? $data['school_id']
            : $user->school_id,
        'option_id' => $data['option_id'],
        'created_by' => $user->id
    ]);
}

public function update(Classe $class, array $data)
{
    $class->update([
        'name' => $data['name'],
        'section' => $data['section'],
        'level' => $data['level'] ?? 1,
        'school_id' => auth()->user()->role->name === 'Super Administrateur'
            ? $data['school_id']
            : auth()->user()->school_id,
        'option_id' => $data['option_id']
    ]);

    return $class;
}

    public function delete(Classe $class)
    {
        return $class->delete();
    }
}
