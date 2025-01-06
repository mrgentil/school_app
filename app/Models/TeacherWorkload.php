<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherWorkload extends Model
{
    use HasFactory;
    protected $fillable = [
        'teacher_id',
        'academic_year_id',
        'semester_id',
        'course_id',
        'number_of_students',
        'number_of_hours',
        'workload',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function course()
    {
        return $this->belongsTo(Subject::class);
    }
}
