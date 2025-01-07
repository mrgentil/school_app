<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasPromotionPermissions;
use App\Traits\HasRoles;
use App\Traits\Searchable;
use App\Traits\HasProgramPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasClassPermissions;
use App\Traits\HasOptionPermissions;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasClassPermissions, HasOptionPermissions, HasPromotionPermissions, HasProgramPermissions, Searchable, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'adress',
        'avatar',
        'phone',
        'first_name',
        'last_name',
        'gender',
        'role_id',
        'school_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relation avec Teacher
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function canManagePromotions(): bool
    {
        return $this->hasAnyRole(['Super Administrateur', 'Administrateur']);
    }

    public function canManageAllPromotions(): bool
    {
        return $this->hasRole('Super Administrateur');
    }

    public function canManageOwnPromotions(): bool
    {
        return $this->hasAnyRole(['Super Administrateur', 'Administrateur']);
    }


    public function canManagePrograms(): bool
    {
        return $this->hasAnyRole(['Super Administrateur', 'Administrateur']);
    }

    public function canManageAllPrograms(): bool
    {
        return $this->hasRole('Super Administrateur');
    }

    public function canManageOwnPrograms(): bool
    {
        return $this->hasAnyRole(['Super Administrateur', 'Administrateur']);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

}
