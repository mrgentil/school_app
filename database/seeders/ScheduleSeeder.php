<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Récupérer la liste des professeurs (users avec un rôle de professeur)
        $teachers = DB::table('users')
            ->where('role_id', Role::where('name', 'Professeur')->first()->id)
            ->inRandomOrder()
            ->get();
        for ($i = 0; $i < 20; $i++) {
            $teacher = $teachers->random(); // Sélectionner un professeur aléatoire

            DB::table('schedules')->insert([
                'class_id' => $faker->numberBetween(1, 10),
                'subject_id' => $faker->numberBetween(1, 20),
                'teacher_id' => $teacher->id,
                'created_by' => $teacher->id,
                'start_time' => $faker->time(),
                'end_time' => $faker->time(),
                'day_of_week' => $faker->dayOfWeek(),
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }
}
