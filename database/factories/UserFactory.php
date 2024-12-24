<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\School; // Ajoutez cette ligne
use App\Models\Role;   // Ajoutez cette ligne également si nécessaire

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'avatar' => $this->faker->imageUrl(100, 100, 'people', true, 'User'),
            'adress' => $this->faker->address,
            'phone' => $this->faker->optional()->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => $this->faker->optional()->dateTimeThisYear,
            'password' => bcrypt('password'),
            'school_id' => School::factory(), // Assurez-vous que ce modèle est bien importé
            'role_id' => Role::factory(),     // Assurez-vous que ce modèle est bien importé
            'remember_token' => \Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
