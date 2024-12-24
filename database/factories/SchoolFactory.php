<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    protected $model = \App\Models\School::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
  public function definition()
     {
         return [
             'name' => $this->faker->company . ' School',
             'logo' => $this->faker->imageUrl(200, 200, 'education', true, 'School'),
             'adress' => $this->faker->address,
             'created_at' => now(),
             'updated_at' => now(),
         ];
     }
}
