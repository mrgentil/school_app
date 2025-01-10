<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    protected $model = \App\Models\Exam::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'exam_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'duration' => $this->faker->numberBetween(30, 180), // Durée en minutes

            'class_id' => $this->faker->numberBetween(1, 10), // Assurez-vous que les classes existent
            'subject_id' => $this->faker->numberBetween(1, 10), // Assurez-vous que les matières existent
            'exam_type_id' => $this->faker->numberBetween(1, 5), // Types d'examen
        ];
    }
}
