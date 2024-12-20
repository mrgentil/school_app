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
            ['name' => 'Teacher', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Student', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tutor', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
