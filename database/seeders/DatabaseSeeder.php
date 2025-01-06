<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            SchoolSeeder::class,            // Les écoles d'abord
            RolesTableSeeder::class,        // Les rôles ensuite
            UsersTableSeeder::class,        // Les utilisateurs (Super Admin, Admin, Élèves, Professeurs)

            OptionSeeder::class,            // Les options nécessaires pour les classes
            ClassSeeder::class,             // Les classes
            PromotionSeeder::class,         // Les promotions associées aux classes
            StudentSeeder::class,           // Les étudiants, après que les classes et écoles sont définies
            StudentHistorySeeder::class,    // Historique des étudiants
            SubjectSeeder::class,           // Les matières
            TeacherSeeder::class,
            SubjectTeacherSeeder::class// Les professeurs
        ]);


        /* // Générer 20 écoles
                $schools = School::factory(20)->create();

                // Générer 4 rôles
                Role::factory()->create(['name' => 'Administrateur']);
                Role::factory()->create(['name' => 'Teacher']);
                Role::factory()->create(['name' => 'Student']);
                Role::factory()->create(['name' => 'Tutor']);

                // Générer 50 utilisateurs
                User::factory(50)->create(); */
    }


}
