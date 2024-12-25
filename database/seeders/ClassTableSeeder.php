<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('classes')->insert([
            ['name' => 'Première ', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Deuxième', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Troisieme', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Quatrieme', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cinquieme', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sixieme', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
