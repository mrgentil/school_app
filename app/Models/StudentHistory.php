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
        'start_date',
        'end_date',
        'status',
        'notes'
    ];

    // Définir les attributs qui doivent être convertis en dates
    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at'
    ];

    // Convertir manuellement start_date en Carbon si nécessaire
    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    // Convertir manuellement end_date en Carbon si nécessaire
    public function getEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

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
}
