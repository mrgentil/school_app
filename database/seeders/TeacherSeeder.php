<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use App\Models\School;
use App\Models\Classe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        // Récupérer les utilisateurs ayant le rôle de professeur
        $teacherUsers = User::whereHas('role', function ($query) {
            $query->where('name', 'Professeur');
        })->get();

        // Récupérer toutes les écoles, matières et classes
        $schools = School::all();
        $subjects = Subject::all();
        $classes = Classe::all();

        // Associer chaque utilisateur-professeur à la table `teachers`
        foreach ($teacherUsers as $user) {
            $teacher = Teacher::create([
                'user_id' => $user->id,
                'school_id' => $user->school_id,
                'speciality' => fake()->randomElement(['Mathématiques', 'Physique', 'Histoire', 'Biologie']),
                'status' => 'active',
            ]);

            // Créer des relations aléatoires entre les professeurs, matières, et classes
            $assignedSubjects = $subjects->random(rand(1, 3)); // Chaque professeur enseigne 1 à 3 matières
            $assignedClasses = $classes->random(rand(1, 3)); // Chaque professeur enseigne dans 1 à 3 classes

            foreach ($assignedSubjects as $subject) {
                foreach ($assignedClasses as $class) {
                    // Relation dans la table pivot `subject_teacher`
                    DB::table('subject_teacher')->insert([
                        'teacher_id' => $teacher->id,
                        'subject_id' => $subject->id,
                        'class_id' => $class->id,
                        'school_id' => $teacher->school_id,
                        'academic_year' => now()->year,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Relation dans la table pivot `class_subject`
                    DB::table('class_subject')->insertOrIgnore([
                        'class_id' => $class->id,
                        'subject_id' => $subject->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
