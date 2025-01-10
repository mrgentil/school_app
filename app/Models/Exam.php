<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'exam_date',
        'duration',
        'is_published',
        'exam_type_id',
        'class_id',
        'subject_id',
        'created_by',

    ];

    /**
     * Get the class associated with the exam.
     */
    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id'); // Remplacez ClassModel par le nom réel de votre modèle de classe
    }

    /**
     * Get the subject associated with the exam.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id'); // Remplacez Subject par le nom réel de votre modèle de matière
    }

    /**
     * Get the exam type associated with the exam.
     */
    public function examType()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id'); // Remplacez ExamType par le nom réel de votre modèle de type d'examen
    }

    /**
     * Get the user who created the exam.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function school()
    {
        return $this->creator->school();
    }


    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
