<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schools')->insert([
            [
                'name' => 'Ecole Universelle',
                'adress' => 'Admin Address',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
