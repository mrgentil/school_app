<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = \App\Models\Question::class;

    public function definition()
    {
        return [
            'question' => $this->faker->sentence(10),
            'type' => $this->faker->randomElement(['Choix Multiple', 'Redaction']),
            'options' => json_encode([
                'A' => $this->faker->word(),
                'B' => $this->faker->word(),
                'C' => $this->faker->word(),
                'D' => $this->faker->word(),
            ]),
            'correct_answer' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'subject_id' => $this->faker->numberBetween(1, 10), // Assurez-vous que les matières existent
            'is_active' => $this->faker->boolean(90), // 90% de probabilité que la question soit active
        ];
    }
}
