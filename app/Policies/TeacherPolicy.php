<?php

namespace App\Policies;

use App\Models\Teacher;
use App\Models\User;

class TeacherPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['Super Administrateur', 'Administrateur']);
    }

    public function view(User $user, Teacher $teacher): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur' &&
               $user->school_id === $teacher->school_id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role->name, ['Super Administrateur', 'Administrateur']);
    }

    public function update(User $user, Teacher $teacher): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur' &&
               $user->school_id === $teacher->school_id;
    }

    public function delete(User $user, Teacher $teacher): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur' &&
               $user->school_id === $teacher->school_id;
    }

    public function assignSubjects(User $user, Teacher $teacher): bool
    {
        if ($user->role->name === 'Super Administrateur') {
            return true;
        }

        return $user->role->name === 'Administrateur' &&
               $user->school_id === $teacher->school_id;
    }
}
