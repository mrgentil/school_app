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
        return $this->belongsToMany(Classe::class, 'subject_teacher', 'teacher_id', 'class_id');
    }

    public function assignedClasses()
    {
        return $this->belongsToMany(Classe::class, 'subject_teacher', 'teacher_id', 'class_id')
            ->withPivot(['subject_id', 'school_id', 'academic_year'])
            ->withTimestamps();
    }
}
