<?php

namespace App\Services;

use App\Models\Classe;
use App\Models\Exam;
use App\Models\User;

class ExamService
{
    public function create(array $data): Exam
    {
        return Exam::create($data);
    }

    public function update(Exam $exam, array $data): bool
    {
        return $exam->update($data);
    }

    public function delete(Exam $exam): bool
    {
        return $exam->delete();
    }
}
