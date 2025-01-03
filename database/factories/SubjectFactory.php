<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'code' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'description' => $this->faker->sentence,
            'created_by' => 1, // Super Admin par défaut
            'school_id' => 1,  // Associez une école par défaut ou choisissez aléatoirement dans vos données
        ];
    }
}
