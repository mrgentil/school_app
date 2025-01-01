<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            [
                'name' => 'École Centrale',
                'adress' => '123 Avenue Principale, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Collège Saint-Joseph',
                'adress' => '456 Rue des Études, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Lycée Excellence',
                'adress' => '789 Boulevard du Savoir, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Institut Notre-Dame',
                'adress' => '10 Avenue des Sciences, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Collège Saint-Pierre',
                'adress' => '15 Rue de la Paix, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Lycée Modern',
                'adress' => '20 Boulevard de l\'Innovation, Ville',
                'logo' => null,
            ],
            [
                'name' => 'École du Progrès',
                'adress' => '25 Avenue du Succès, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Institut Technique',
                'adress' => '30 Rue de l\'Industrie, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Collège International',
                'adress' => '35 Boulevard des Nations, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Lycée Polyvalent',
                'adress' => '40 Avenue de la Diversité, Ville',
                'logo' => null,
            ],
            [
                'name' => 'École des Arts',
                'adress' => '45 Rue de la Créativité, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Institut Supérieur',
                'adress' => '50 Boulevard de l\'Excellence, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Collège du Futur',
                'adress' => '55 Avenue de l\'Avenir, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Lycée Scientifique',
                'adress' => '60 Rue des Découvertes, Ville',
                'logo' => null,
            ],
            [
                'name' => 'École des Sciences',
                'adress' => '65 Boulevard de la Recherche, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Institut Commercial',
                'adress' => '70 Avenue du Commerce, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Collège Technique',
                'adress' => '75 Rue de la Technologie, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Lycée des Langues',
                'adress' => '80 Boulevard International, Ville',
                'logo' => null,
            ],
            [
                'name' => 'École Professionnelle',
                'adress' => '85 Avenue des Métiers, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Institut des Sports',
                'adress' => '90 Rue de l\'Athlétisme, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Collège des Arts',
                'adress' => '95 Boulevard Culturel, Ville',
                'logo' => null,
            ],
            [
                'name' => 'Lycée Littéraire',
                'adress' => '100 Avenue des Lettres, Ville',
                'logo' => null,
            ],
            [
                'name' => 'École de Commerce',
                'adress' => '105 Rue des Affaires, Ville',
                'logo' => null,
            ],
        ];

        foreach ($schools as $school) {
            School::create($school);
        }
    }
}
