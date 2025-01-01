<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Récupérer les IDs des rôles
        $superAdminRoleId = Role::where('name', 'Super Administrateur')->first()->id;
        $adminRoleId = Role::where('name', 'Administrateur')->first()->id;
        $studentRoleId = Role::where('name', 'Eleve')->first()->id;

        // Récupérer toutes les écoles
        $schoolIds = School::pluck('id')->toArray();


//        DB::table('users')->insert([
//            [
//                'name' => 'MrGentil',
//                'first_name' => 'Tshitsho',
//                'last_name' => 'Bilongo',
//                'gender' => 'Homme',
//                'email' => 'tshitshob@gmail.com',
//                'password' => Hash::make('password'),
//                'adress' => 'Admin Address',
//                'phone' => '+243812380589',
//                'role_id' => 1, // Super Admin
//                'school_id' => 1, // Ecole Universelle
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//        ]);

        // Super Admin
        User::create([
            'name' => 'Super Administrateur',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'gender' => 'Masculin',
            'adress' => '123 Admin Street',
            'email' => 'tshitshob@gmail.com',
            'phone' => '+243123456789',
            'password' => Hash::make('password'),
            'school_id' => $schoolIds[0], // Première école
            'role_id' => $superAdminRoleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Créer un administrateur pour chaque école
        foreach ($schoolIds as $schoolId) {
            User::create([
                'name' => "Admin École $schoolId",
                'first_name' => "Admin",
                'last_name' => "École $schoolId",
                'gender' => 'Masculin',
                'adress' => "Adresse École $schoolId",
                'email' => "admin{$schoolId}@ecole.com",
                'phone' => "+24376543210$schoolId",
                'password' => Hash::make('password'),
                'school_id' => $schoolId,
                'role_id' => $adminRoleId,
            ]);
        }

        // Créer 50 élèves
        foreach (range(1, 50) as $index) {
            User::create([
                'name' => fake()->name,
                'first_name' => fake()->firstName,
                'last_name' => fake()->lastName,
                'gender' => fake()->randomElement(['Masculin', 'Féminin']),
                'adress' => fake()->address,
                'email' => fake()->unique()->safeEmail,
                'phone' => fake()->phoneNumber,
                'password' => Hash::make('password'),
                'school_id' => fake()->randomElement($schoolIds), // Utiliser un ID d'école existant
                'role_id' => $studentRoleId,
            ]);
        }
    }
}
