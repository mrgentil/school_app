<?php

namespace App\Traits;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait HasStudentPermissions
{
    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['search'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%");
            })
                ->orWhere('registration_number', 'like', "%{$filters['search']}%");
        }

        if (!empty($filters['school_id'])) {
            $query->where('school_id', $filters['school_id']);
        }

        if (!empty($filters['class_id'])) {
            $query->where('class_id', $filters['class_id']);
        }

        if (!empty($filters['option_id'])) {
            $query->where('option_id', $filters['option_id']);
        }

        if (!empty($filters['promotion_id'])) {
            $query->where('promotion_id', $filters['promotion_id']);
        }

        return $query;
    }
}
