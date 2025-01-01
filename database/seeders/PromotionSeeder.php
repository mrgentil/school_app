<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $promotions = [
            // Promotions historiques
            [
                'name' => 'Promotion 2018-2019',
                'created_by' => 1,
                'school_id' => 1,
                'academic_year' => '2018-2019'
            ],
            [
                'name' => 'Promotion 2019-2020',
                'created_by' => 1,
                'school_id' => 1,
                'academic_year' => '2019-2020'
            ],
            [
                'name' => 'Promotion 2020-2021',
                'created_by' => 1,
                'school_id' => 1,
                'academic_year' => '2020-2021'
            ],
            [
                'name' => 'Promotion 2021-2022',
                'created_by' => 1,
                'school_id' => 1,
                'academic_year' => '2021-2022'
            ],
            [
                'name' => 'Promotion 2022-2023',
                'created_by' => 1,
                'school_id' => 1,
                'academic_year' => '2022-2023'
            ],
            [
                'name' => 'Promotion 2023-2024',
                'created_by' => 1,
                'school_id' => 1,
                'academic_year' => '2023-2024'
            ],

            // Promotions par école
            [
                'name' => 'Sciences 2023-2024',
                'created_by' => 2,
                'school_id' => 2,
                'academic_year' => '2023-2024'
            ],
            [
                'name' => 'Littéraire 2023-2024',
                'created_by' => 2,
                'school_id' => 4,
                'academic_year' => '2023-2024'
            ],
            [
                'name' => 'Technique 2023-2024',
                'created_by' => 3,
                'school_id' => 3,
                'academic_year' => '2023-2024'
            ],
            [
                'name' => 'Commerce 2023-2024',
                'created_by' => 3,
                'school_id' => 5,
                'academic_year' => '2023-2024'
            ],

            // Promotions spéciales
            [
                'name' => 'Excellence 2023-2024',
                'created_by' => 1,
                'school_id' => 1,
                'academic_year' => '2023-2024'
            ],
            [
                'name' => 'Prépa Sciences 2023-2024',
                'created_by' => 2,
                'school_id' => 2,
                'academic_year' => '2023-2024'
            ],
            [
                'name' => 'Prépa Commerce 2023-2024',
                'created_by' => 3,
                'school_id' => 5,
                'academic_year' => '2023-2024'
            ],

            // Promotions futures
            [
                'name' => 'Promotion 2024-2025',
                'created_by' => 1,
                'school_id' => 1,
                'academic_year' => '2024-2025'
            ],
            [
                'name' => 'Sciences 2024-2025',
                'created_by' => 2,
                'school_id' => 2,
                'academic_year' => '2024-2025'
            ],
            [
                'name' => 'Technique 2024-2025',
                'created_by' => 3,
                'school_id' => 3,
                'academic_year' => '2024-2025'
            ],

            // Promotions par niveau
            [
                'name' => 'Terminale S 2023-2024',
                'created_by' => 2,
                'school_id' => 2,
                'academic_year' => '2023-2024'
            ],
            [
                'name' => 'Terminale L 2023-2024',
                'created_by' => 2,
                'school_id' => 4,
                'academic_year' => '2023-2024'
            ],
            [
                'name' => 'Terminale Tech 2023-2024',
                'created_by' => 3,
                'school_id' => 3,
                'academic_year' => '2023-2024'
            ],
            [
                'name' => 'Terminale Com 2023-2024',
                'created_by' => 3,
                'school_id' => 5,
                'academic_year' => '2023-2024'
            ],
        ];

        foreach ($promotions as $promotion) {
            Promotion::create($promotion);
        }
    }
}
