<?php

namespace App\Services;

use App\Models\Class;
use App\Models\Classe;

class ClassService
{
    public function getClassesForUser($user)
    {
        if ($user->canManageAllClasses()) {
            return Classe::with(['creator', 'school'])->latest()->get();
        }

        return Classe::with(['creator', 'school'])
            ->where('created_by', $user->id)
            ->latest()
            ->get();
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
