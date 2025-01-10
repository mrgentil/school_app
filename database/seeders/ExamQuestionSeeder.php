<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;

class ExamQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crée 20 examens
        Exam::factory(20)->create()->each(function ($exam) {
            // Associe entre 20 et 30 questions aléatoirement à chaque examen
            Question::factory(rand(20, 30))->create([
                'exam_id' => $exam->id,
            ]);
        });
    }
}
