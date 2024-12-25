<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('options')->insert([
            ['name' => 'Pédagogie', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Electroniqe', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maternelle', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Scientifique', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Literaire', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
