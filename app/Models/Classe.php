<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'created_by', 'school_id', 'level', 'option_id', 'section'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'class_id', 'subject_id');
    }


    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher', 'class_id', 'teacher_id');
    }
}
