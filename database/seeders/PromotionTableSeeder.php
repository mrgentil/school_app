<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('promotions')->insert([
            ['name' => '2020 - 2021', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '2021 - 2022', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '2022 - 2023', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '2023 - 2024', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
