<?php

namespace Database\Seeders;

use App\Models\Classe; // Si votre modèle pour `classes` s'appelle `Classe`
use App\Models\School;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        // Créer 50 matières
        $subjects = Subject::factory()->count(50)->create();

        // Récupérer toutes les écoles
        $schools = School::all();

        // Récupérer toutes les classes
        $classes = Classe::all();

        // Récupérer tous les enseignants
        $teachers = Teacher::all();

        // Boucle sur les écoles, classes et matières pour les associer
        foreach ($schools as $school) {
            foreach ($classes->where('school_id', $school->id) as $class) {
                foreach ($subjects as $subject) {
                    // Associer la matière à la classe
                    $class->subjects()->attach($subject->id, ['school_id' => $school->id]);

                    // Assigner un enseignant aléatoire à la matière pour la classe
                    if ($teachers->isNotEmpty()) {
                        $randomTeacher = $teachers->random();
                        $subject->teachers()->attach($randomTeacher->id, [
                            'class_id' => $class->id,
                            'school_id' => $school->id,
                            'academic_year' => now()->year,
                        ]);
                    }
                }
            }
        }
    }
}
