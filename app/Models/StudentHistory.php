<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StudentHistory extends Model
{
    protected $fillable = [
        'student_id',
        'school_id',
        'class_id',
        'option_id',
        'promotion_id',
       'academic_year',
        'semester',
        'average_score',
        'rank',
        'decision',
        'teacher_remarks',
        'conduct_grade',
        'attendance_record',
        'start_date',
        'end_date',
        'status'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at'
    ];

    // Relations
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    // Accesseurs
    public function getFormattedAverageAttribute()
    {
        return $this->average_score ? number_format($this->average_score, 2) . '/20' : '-';
    }

    public function getFormattedRankAttribute()
    {
        return $this->rank ? $this->rank . 'ème' : '-';
    }
}
