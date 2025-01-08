<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'subject_id',
        'teacher_id',
        'start_time',
        'created_by',
        'end_time',
        'day_of_week',
    ];

    public function class()
    {
        return $this->belongsTo(Classe::class);
    }

    public function school()
    {
        return $this->hasOneThrough(School::class, Classe::class,
            'id', 'id', 'class_id', 'school_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }



    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Modèle Schedule
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }


}
