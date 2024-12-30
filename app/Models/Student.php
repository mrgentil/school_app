<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStudentPermissions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasStudentPermissions;

    protected $fillable = [
        'user_id',
        'registration_number',
        'school_id',
        'class_id',
        'option_id',
        'promotion_id'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(StudentHistory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
