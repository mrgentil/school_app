<?php

namespace App\Providers;

use App\Models\Classe;
use App\Models\Exam;
use App\Models\Option;
use App\Models\Program;
use App\Models\Promotion;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentHistory;
use App\Models\Subject;
use App\Models\Teacher;
use App\Policies\ClassPolicy;
use App\Policies\ExamPolicy;
use App\Policies\OptionPolicy;
use App\Policies\ProgramPolicy;
use App\Policies\RolePolicy;
use App\Policies\SchedulePolicy;
use App\Policies\SchoolPolicy;
use App\Policies\StudentHistoryPolicy;
use App\Policies\StudentPolicy;
use App\Policies\StudentPromotionPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TeacherPolicy;
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
        StudentHistory::class => StudentHistoryPolicy::class,
        Subject::class => SubjectPolicy::class,
        Teacher::class => TeacherPolicy::class,
        Program::class => ProgramPolicy::class,
        Schedule::class => SchedulePolicy::class,
        Exam::class => ExamPolicy::class,

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
