<?php

namespace App\Policies;

use App\Models\Exam;
use App\Models\User;

class ExamPolicy
{
    public function view(User $user, Exam $exam)
    {
        return $user->role->name === 'Administrateur' || $user->school_id === $exam->class->school_id;
    }

    public function create(User $user)
    {
        return $user->role->name === 'admin' || $user->role->name === 'teacher';
    }

    public function update(User $user, Exam $exam)
    {
        return $user->id === $exam->created_by || $user->role->name === 'admin';
    }

    public function delete(User $user, Exam $exam)
    {
        return $user->role->name === 'admin';
    }
}
