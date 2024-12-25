<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Super Administrateur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Administrateur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Professeur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Eleve', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tuteur', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
