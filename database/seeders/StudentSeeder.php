<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer tous les IDs d'utilisateurs existants sauf les administrateurs
        $userIds = User::whereHas('role', function($query) {
            $query->where('name', 'Élève'); // Assurez-vous que ce rôle existe
        })->pluck('id')->toArray();

        // Créer 50 étudiants ou moins selon le nombre d'utilisateurs disponibles
        $count = min(count($userIds), 50);

        foreach (range(0, $count - 1) as $index) {
            Student::create([
                'user_id' => $userIds[$index],
                'registration_number' => 'STD' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'school_id' => fake()->numberBetween(1, 3),
                'class_id' => fake()->numberBetween(1, 6),
                'option_id' => fake()->numberBetween(1, 4),
                'promotion_id' => fake()->numberBetween(1, 3),
            ]);
        }
    }
}
