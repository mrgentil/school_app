<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            // Classes de base existantes
            ['name' => '6ème A', 'section' => 'Primaire', 'level' => 1, 'created_by' => 2, 'school_id' => 1, 'option_id' => null],
            ['name' => '5ème A', 'section' => 'Secondaire', 'level' => 2, 'created_by' => 2, 'school_id' => 1, 'option_id' => 1],
            ['name' => '4ème Sciences', 'section' => 'Secondaire', 'level' => 3, 'created_by' => 3, 'school_id' => 2, 'option_id' => 2],
            ['name' => '3ème Commercial', 'section' => 'Secondaire', 'level' => 4, 'created_by' => 3, 'school_id' => 2, 'option_id' => 3],
            ['name' => '2nde Technique', 'section' => 'Secondaire', 'level' => 5, 'created_by' => 4, 'school_id' => 3, 'option_id' => 4],
            ['name' => '1ère Technique', 'section' => 'Secondaire', 'level' => 6, 'created_by' => 4, 'school_id' => 3, 'option_id' => 4],

            // Nouvelles classes
            // École 1 - Classes supplémentaires
            ['name' => '6ème B', 'section' => 'Primaire', 'level' => 1, 'created_by' => 2, 'school_id' => 1, 'option_id' => null],
            ['name' => '5ème B', 'section' => 'Secondaire', 'level' => 2, 'created_by' => 2, 'school_id' => 1, 'option_id' => 1],
            ['name' => '4ème A', 'section' => 'Secondaire', 'level' => 3, 'created_by' => 2, 'school_id' => 1, 'option_id' => 1],
            ['name' => '3ème A', 'section' => 'Secondaire', 'level' => 4, 'created_by' => 2, 'school_id' => 1, 'option_id' => 1],

            // École 2 - Classes supplémentaires
            ['name' => '6ème Sciences', 'section' => 'Primaire', 'level' => 1, 'created_by' => 3, 'school_id' => 2, 'option_id' => 2],
            ['name' => '5ème Sciences', 'section' => 'Secondaire', 'level' => 2, 'created_by' => 3, 'school_id' => 2, 'option_id' => 2],
            ['name' => '2nde Sciences', 'section' => 'Secondaire', 'level' => 5, 'created_by' => 3, 'school_id' => 2, 'option_id' => 2],
            ['name' => '1ère Sciences', 'section' => 'Secondaire', 'level' => 6, 'created_by' => 3, 'school_id' => 2, 'option_id' => 2],

            // École 3 - Classes supplémentaires
            ['name' => '6ème Tech', 'section' => 'Primaire', 'level' => 1, 'created_by' => 4, 'school_id' => 3, 'option_id' => 4],
            ['name' => '5ème Tech', 'section' => 'Secondaire', 'level' => 2, 'created_by' => 4, 'school_id' => 3, 'option_id' => 4],
            ['name' => '4ème Tech', 'section' => 'Secondaire', 'level' => 3, 'created_by' => 4, 'school_id' => 3, 'option_id' => 4],
            ['name' => '3ème Tech', 'section' => 'Secondaire', 'level' => 4, 'created_by' => 4, 'school_id' => 3, 'option_id' => 4],

            // École 4
            ['name' => '6ème Littéraire', 'section' => 'Primaire', 'level' => 1, 'created_by' => 2, 'school_id' => 4, 'option_id' => 1],
            ['name' => '5ème Littéraire', 'section' => 'Secondaire', 'level' => 2, 'created_by' => 2, 'school_id' => 4, 'option_id' => 1],
            ['name' => '4ème Littéraire', 'section' => 'Secondaire', 'level' => 3, 'created_by' => 2, 'school_id' => 4, 'option_id' => 1],
            ['name' => '3ème Littéraire', 'section' => 'Secondaire', 'level' => 4, 'created_by' => 2, 'school_id' => 4, 'option_id' => 1],

            // École 5
            ['name' => '6ème Commerce', 'section' => 'Primaire', 'level' => 1, 'created_by' => 3, 'school_id' => 5, 'option_id' => 3],
            ['name' => '5ème Commerce', 'section' => 'Secondaire', 'level' => 2, 'created_by' => 3, 'school_id' => 5, 'option_id' => 3],
            ['name' => '4ème Commerce', 'section' => 'Secondaire', 'level' => 3, 'created_by' => 3, 'school_id' => 5, 'option_id' => 3],
            ['name' => '3ème Commerce', 'section' => 'Secondaire', 'level' => 4, 'created_by' => 3, 'school_id' => 5, 'option_id' => 3],

            // Classes spécialisées
            ['name' => 'Terminale S', 'section' => 'Secondaire', 'level' => 7, 'created_by' => 2, 'school_id' => 1, 'option_id' => 2],
            ['name' => 'Terminale L', 'section' => 'Secondaire', 'level' => 7, 'created_by' => 2, 'school_id' => 4, 'option_id' => 1],
            ['name' => 'Terminale Tech', 'section' => 'Secondaire', 'level' => 7, 'created_by' => 4, 'school_id' => 3, 'option_id' => 4],
            ['name' => 'Terminale Com', 'section' => 'Secondaire', 'level' => 7, 'created_by' => 3, 'school_id' => 5, 'option_id' => 3],

            // Classes préparatoires
            ['name' => 'Prépa Sciences', 'section' => 'Préparatoire', 'level' => 8, 'created_by' => 3, 'school_id' => 2, 'option_id' => 2],
            ['name' => 'Prépa Commerce', 'section' => 'Préparatoire', 'level' => 8, 'created_by' => 3, 'school_id' => 5, 'option_id' => 3],
            ['name' => 'Prépa Technique', 'section' => 'Préparatoire', 'level' => 8, 'created_by' => 4, 'school_id' => 3, 'option_id' => 4],
        ];

        foreach ($classes as $class) {
            Classe::create($class);
        }
    }
}
