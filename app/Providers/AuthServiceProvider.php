<?php

namespace App\Providers;

use App\Models\Classe;
use App\Models\Option;
use App\Models\Promotion;
use App\Models\Role;
use App\Models\School;
use App\Models\Student;
use App\Policies\ClassPolicy;
use App\Policies\OptionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SchoolPolicy;
use App\Policies\StudentPolicy;
use App\Policies\UserPolicy;
use App\Policies\PromotionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        School::class => SchoolPolicy::class,
        Classe::class => ClassPolicy::class,
        Option::class => OptionPolicy::class,
        Promotion::class => PromotionPolicy::class,
        Student::class => StudentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Définition de la Gate pour la gestion des utilisateurs
        Gate::define('manage-users', function (User $user) {
            return $user->hasAnyRole(['Super Administrateur', 'Administrateur']);
        });
    }
}
