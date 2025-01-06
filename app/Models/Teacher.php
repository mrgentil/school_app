<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'speciality',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher')
            ->withPivot(['class_id', 'school_id', 'academic_year'])
            ->withTimestamps();
    }


    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'subject_teacher',
            'teacher_id', 'class_id');
    }

    public function totalWorkload($academicYear = null)
    {
        $academicYear = $academicYear ?? now()->format('Y');

        // Récupérer toutes les matières de l'enseignant pour l'année académique donnée
        $subjects = $this->subjects()
            ->wherePivot('academic_year', $academicYear)
            ->get();




        // Calculer la charge totale en heures
        $totalHours = $subjects->reduce(function ($carry, $subject) {
            return $carry + $subject->pivot->hours_per_week;
        }, 0);

        return $totalHours;
    }

    public function isOverloaded($maxHours = 5, $academicYear = null)
    {
        return $this->totalWorkload($academicYear) > $maxHours;
    }


    public function assignedClasses()
    {
        return $this->belongsToMany(Classe::class, 'subject_teacher', 'teacher_id', 'class_id')
            ->withPivot(['subject_id', 'school_id', 'academic_year'])
            ->withTimestamps();
    }
}
