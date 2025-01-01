<?php

namespace Database\Seeders;

use App\Models\StudentHistory;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentHistorySeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $academicYears = ['2020-2021','2021-2022','2022-2023', '2023-2024'];
        $semesters = ['Semestre 1', 'Semestre 2'];
        $decisions = ['En cours', 'Admis', 'Ajourné', 'Redouble'];

        foreach ($students as $student) {
            foreach ($academicYears as $year) {
                foreach ($semesters as $semester) {
                    StudentHistory::create([
                        'student_id' => $student->id,
                        'school_id' => $student->school_id,
                        'class_id' => $student->class_id,
                        'option_id' => $student->option_id,
                        'promotion_id' => $student->promotion_id,
                        'academic_year' => $year,
                        'semester' => $semester,
                        'average_score' => fake()->randomFloat(2, 0, 20),
                        'rank' => fake()->numberBetween(1, 50),
                        'decision' => fake()->randomElement($decisions),
                        'teacher_remarks' => fake()->text(200),
                        'conduct_grade' => fake()->randomElement(['A', 'B', 'C', 'D']),
                        'attendance_record' => fake()->numberBetween(80, 100) . '% de présence',
                        'start_date' => fake()->dateTimeBetween('-2 years', 'now'),
                        'end_date' => fake()->optional(0.7)->dateTimeBetween('now', '+6 months'),
                        'status' => fake()->randomElement(['active', 'inactive']),
                    ]);
                }
            }
        }
    }
}
