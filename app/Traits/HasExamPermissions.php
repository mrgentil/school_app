<?php

namespace App\Traits;

use App\Models\Exam;

class HasExamPermissions
{
    public function publishExam(Exam $exam): bool
    {
        return $exam->update(['is_published' => true]);
    }

    public function unpublishExam(Exam $exam): bool
    {
        return $exam->update(['is_published' => false]);
    }
}
