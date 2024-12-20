<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'MrGentil',
                'first_name' => 'Tshitsho',
                'last_name' => 'Bilongo',
                'gender' => 'Homme',
                'email' => 'tshitshob@gmail.com',
                'password' => Hash::make('password'),
                'adress' => 'Admin Address',
                'phone' => '+243812380589',
                'role_id' => 1, // Super Admin
                'school_id' => 1, // Ecole Universelle
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
