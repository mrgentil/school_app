<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)
            ->withPivot('school_id', 'hours_per_week')
            ->withTimestamps();
    }
}