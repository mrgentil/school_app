<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run(): void
    {
        $options = [
            [
                'name' => 'Littéraire',
                'created_by' => 1, // Super Admin
                'school_id' => 1,
            ],
            [
                'name' => 'Scientifique',
                'created_by' => 1,
                'school_id' => 1,
            ],
            [
                'name' => 'Commercial',
                'created_by' => 2, // Admin École 1
                'school_id' => 2,
            ],
            [
                'name' => 'Technique',
                'created_by' => 3, // Admin École 2
                'school_id' => 3,
            ],
        ];

        foreach ($options as $option) {
            Option::create($option);
        }
    }
}
