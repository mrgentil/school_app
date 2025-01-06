<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $classes = Classe::all();
        $academicYears = ['2024', '2025', '2026'];

        foreach ($teachers as $teacher) {
            foreach ($subjects->random(rand(1, 5)) as $subject) {
                DB::table('subject_teacher')->insert([
                    'teacher_id' => $teacher->id,
                    'subject_id' => $subject->id,
                    'class_id' => $classes->random()->id,
                    'school_id' => $teacher->school_id,
                    'academic_year' => $academicYears[array_rand($academicYears)],
                    'hours_per_week' => rand(2, 10), // Ajouter des heures entre 2 et 10
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
