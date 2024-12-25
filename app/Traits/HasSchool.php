<?php

namespace App\Traits;

use App\Models\School;

trait HasSchool
{
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function belongsToSchool(School $school): bool
    {
        return $this->school_id === $school->id;
    }

    public function isFromSameSchool(self $user): bool
    {
        return $this->school_id === $user->school_id;
    }
}
