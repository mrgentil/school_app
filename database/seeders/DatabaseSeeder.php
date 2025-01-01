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
            //ClassTableSeeder::class,
            //PromotionTableSeeder::class,
            //OptionTableSeeder::class,
            SchoolSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            OptionSeeder::class,
            ClassSeeder::class,
            PromotionSeeder::class,
            StudentSeeder::class,
            StudentHistorySeeder::class,
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
