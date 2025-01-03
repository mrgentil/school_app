<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory; // Active les factories pour ce modèle
    protected $fillable = ['name', 'code', 'description', 'school_id', 'created_by'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subject) {
            if (empty($subject->code)) {
                $subject->code = self::generateSubjectCode($subject->name);
            }
        });
    }

    private static function generateSubjectCode($name)
    {
        // Prend les premières lettres de chaque mot et les met en majuscule
        $code = collect(explode(' ', $name))
            ->map(function ($word) {
                return strtoupper(substr($word, 0, 1));
            })
            ->join('');

        // Ajoute un nombre aléatoire si nécessaire pour l'unicité
        $baseCode = $code;
        $counter = 1;

        while (self::where('code', $code)->exists()) {
            $code = $baseCode . $counter;
            $counter++;
        }

        return $code;
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher')
            ->withPivot(['class_id', 'school_id', 'academic_year'])
            ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'class_subject', 'subject_id', 'class_id');
    }

}
